<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local plugin "resort courses" - Library
 *
 * @package    local_resort_courses
 * @copyright  2013 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('RESORT_COURSES_SORT_FULLNAME_ASC', 1);
define('RESORT_COURSES_SORT_FULLNAME_DESC', 2);
define('RESORT_COURSES_SORT_SHORTNAME_ASC', 3);
define('RESORT_COURSES_SORT_SHORTNAME_DESC', 4);
define('RESORT_COURSES_SORT_COURSEID_ASC', 5);
define('RESORT_COURSES_SORT_COURSEID_DESC', 6);
define('RESORT_COURSES_SORT_STARTDATE_ASC', 7);
define('RESORT_COURSES_SORT_STARTDATE_DESC', 8);


/**
 * Event observer function which is called after an event was caught and which triggers the sorting of the course's category.
 *
 * @param \core\event\base $event The event
 * @return void
 */
function resort_course_eventhandler($event) {
    global $DB;

    // Do not re-sort while testing Moodle core with PHPUnit.
    // This plugin does not use PHPUnit at the moment, but it does break some core PHPUnit tests when installed on a site.
    // Thus, skipping re-sorting is fine at the moment.
    if ((defined('PHPUNIT_TEST') && PHPUNIT_TEST)) {
        return;
    }

    // Get course (because we need its category).
    $eventcourse = get_course($event->objectid);

    // Get category.
    $category = $DB->get_record('course_categories', ['id' => $eventcourse->category]);
    if (!$category) {
        // If the category does not exist for whatever reason, let's return and leave it unsorted.
        return;
    }

    // Sort category.
    resort_course_category($category, false);
}

/**
 * Function to sort all course categories based on a scheduled task.
 */
function resort_courses_cron() {
    // Get all course categories.
    $allcategories = core_course_category::get_all();

    // Get plugin config once for all categories.
    $config = get_config('local_resort_courses');

    // Start cron log output.
    mtrace('[local_resort_courses] Starting re-sorting of all categories');

    try {
        // Iterate over all categories.
        foreach ($allcategories as $category) {
            // Cron log output.
            mtrace('[local_resort_courses] ... Re-sorting category ' . $category->id .
                    ' (Path: ' . $category->path . ' | Name: ' . $category->name . ')');

            // Sort the category, but skip the site-wide cleanup as we do it only once after the loop.
            resort_course_category($category, true, false, $config);
        }
    } finally {
        // Cron log output.
        mtrace('[local_resort_courses] ... Cleaning up course sort order and caches');

        // Cleanup - This should not be needed but we do it just to be safe.
        // This is done in a finally block to make sure that already re-sorted categories are cleaned up
        // even if an exception is thrown while re-sorting a category.
        fix_course_sortorder();
        \core_cache\helper::purge_by_event('changesincourse');
    }

    // End cron log output.
    mtrace('[local_resort_courses] Finished re-sorting of all categories');
}

/**
 * Function to sort a single course category.
 *
 * @param object $category The category to be sorted.
 * @param bool $cronrunning The fact that the re-sorting was triggered by the scheduled task.
 * @param bool $cleanup Whether to run the site-wide course sort order and cache cleanup after re-sorting.
 *                      Callers which re-sort multiple categories should pass false and do the cleanup once afterwards.
 * @param object|null $config The plugin config. If null, it is fetched within this function.
 * @return bool
 */
function resort_course_category($category, $cronrunning = false, $cleanup = true, $config = null) {
    global $DB;

    // Get plugin config if it was not passed by the caller.
    if ($config === null) {
        $config = get_config('local_resort_courses');
    }

    // Get the categories to be skipped according to plugin settings, defaulting to an empty list.
    $skipcategories = !empty($config->skipcategories) ? explode(',', $config->skipcategories) : [];

    // Check if category has to be skipped according to plugin settings.
    if (in_array($category->id, $skipcategories)) {
        // Category has to be skipped.
        // Let's return and leave the category unsorted.
        return true;
    }

    // Check if we skip categories recursively and one of category's parents has to be skipped according to plugin settings.
    if (!empty($config->skipcategoriesrecursively)) {
        $parents = explode("/", $category->path);
        foreach ($parents as $p) {
            if ($p !== '' && in_array($p, $skipcategories)) {
                // Category has to be skipped.
                // Let's return and leave the category unsorted.
                return true;
            }
        }
    }

    // Set the sort criteria.
    // Course names are sorted in PHP (see below), all other fields are sorted in SQL.
    $namefield = null;
    $namedesc = false;
    $sortsql = null;
    switch ($config->sortorder) {
        case RESORT_COURSES_SORT_FULLNAME_ASC:
            $namefield = 'fullname';
            break;
        case RESORT_COURSES_SORT_FULLNAME_DESC:
            $namefield = 'fullname';
            $namedesc = true;
            break;
        case RESORT_COURSES_SORT_SHORTNAME_ASC:
            $namefield = 'shortname';
            break;
        case RESORT_COURSES_SORT_SHORTNAME_DESC:
            $namefield = 'shortname';
            $namedesc = true;
            break;
        case RESORT_COURSES_SORT_COURSEID_ASC:
            $sortsql = "idnumber ASC";
            break;
        case RESORT_COURSES_SORT_COURSEID_DESC:
            $sortsql = "idnumber DESC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_ASC:
            $sortsql = "startdate ASC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_DESC:
            $sortsql = "startdate DESC";
            break;
        default:
            $namefield = 'fullname';
    }

    // Re-sort course category.
    // This is a subset of the function core_course_category::resort_courses().
    // We don't directly use this function as
    // a) it was not there when this plugin was built and does not support sorting by startdate unfortunately.
    // b) it passes the course names through format_string() before sorting them. With multilang course names, the
    // result depends on the language of the user who triggers the sorting. As this plugin re-sorts automatically,
    // regardless of who triggered it, this would result in an unpredictable sort order.

    // Get courses within category.
    // We query the course table directly instead of using get_courses() as get_courses() only returns the courses which
    // are visible to the current user. The re-sorting is meant to cover all courses within the category, regardless
    // of the user who triggered it (for example, a teacher who updates their course and who cannot see other hidden courses).

    // If the courses are sorted by a course name.
    if ($namefield !== null) {
        // Get the courses.
        $courses = $DB->get_records('course', ['category' => $category->id], 'id ASC', 'id, ' . $namefield);

        // Use the raw course names without any tags as sort values, just as Moodle core does,
        // but without formatting them before (see above).
        foreach ($courses as $course) {
            $course->sortby = strip_tags($course->$namefield);
        }

        // Sort the courses naturally and locale-aware, just as Moodle core does.
        core_collator::asort_objects_by_property($courses, 'sortby', core_collator::SORT_NATURAL);

        // Group the courses by their sort values, keeping the order of the sort values.
        $groups = [];
        foreach ($courses as $course) {
            $groups[$course->sortby][] = $course->id;
        }

        // Reverse the order of the sort values if a descending order is configured.
        if ($namedesc) {
            $groups = array_reverse($groups, true);
        }

        // Compose the list of course ids and use the course id as tiebreaker to get a deterministic order
        // for courses with equal sort values.
        $courseids = [];
        foreach ($groups as $group) {
            sort($group, SORT_NUMERIC);
            $courseids = array_merge($courseids, $group);
        }
    } else {
        // Otherwise, get the courses in the configured order and use the course id as tiebreaker to get a deterministic order
        // for courses with equal sort values.
        $courseids = array_keys($DB->get_records('course', ['category' => $category->id], $sortsql . ', id ASC', 'id'));
    }

    // If there are any courses in the category.
    if (count($courseids) > 0) {
        // Do the resorting.
        $i = 1;
        foreach ($courseids as $courseid) {
            $DB->set_field('course', 'sortorder', $category->sortorder + $i, ['id' => $courseid]);
            $i++;
        }

        // Cleanup - This should not be needed but we do it just to be safe.
        if ($cleanup) {
            fix_course_sortorder();
            \core_cache\helper::purge_by_event('changesincourse');
        }

        // Log the event.
        $logevent = \local_resort_courses\event\courses_sorted::create([
            'objectid' => $category->id,
            'context' => context_coursecat::instance($category->id),
            'other' => [
                'cronrunning' => $cronrunning,
            ],
        ]);
        $logevent->trigger();
    }

    // If we have arrived here, the category should be sorted.
    return true;
}
