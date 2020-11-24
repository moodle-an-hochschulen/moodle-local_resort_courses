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

defined('MOODLE_INTERNAL') || die;

define('RESORT_COURSES_SORT_FULLNAME_ASC', 1);
define('RESORT_COURSES_SORT_FULLNAME_DESC', 2);
define('RESORT_COURSES_SORT_SHORTNAME_ASC', 3);
define('RESORT_COURSES_SORT_SHORTNAME_DESC', 4);
define('RESORT_COURSES_SORT_COURSEID_ASC', 5);
define('RESORT_COURSES_SORT_COURSEID_DESC', 6);
define('RESORT_COURSES_SORT_STARTDATE_ASC', 7);
define('RESORT_COURSES_SORT_STARTDATE_DESC', 8);


/**
 * Event handler function which is called after an event was caught and which triggers the sorting of the course's category.
 *
 * @param object $eventdata Event data
 * @return bool
 */
function resort_course_eventhandler($eventdata) {
    global $DB;

    // Do not re-sort while testing Moodle core with PHPUnit.
    // This plugin does not use PHPUnit at the moment, but it does break some core PHPUnit tests when installed on a site.
    // Thus, skipping re-sorting is fine at the moment.
    if ((defined('PHPUNIT_TEST') && PHPUNIT_TEST)) {
        return true;
    }

    // Get plugin config.
    $config = get_config('local_resort_courses');

    // Get course (because we need its category).
    $eventcourse = get_course($eventdata->objectid);
    if (!$eventcourse) {
        // Now we have an error, but if we return false, the event will stay in the event queue.
        // Let's return and leave the category unsorted.
        return true;
    }

    // Get category.
    $category = $DB->get_record('course_categories', array('id' => $eventcourse->category));
    if (!$category) {
        // Now we have an error, but if we return false, the event will stay in the event queue.
        // Let's return and leave the category unsorted.
        return true;
    }

    // Sort category.
    resort_course_category($category, false);

    // Always return true even if something went wrong as, if we would return false, the event would stay in the event queue.
    return true;
}

/**
 * Function to sort all course categories based on a scheduled task.
 */
function resort_courses_cron() {
    // Get all course categories.
    $allcategories = core_course_category::get_all();

    // Start cron log output.
    mtrace('[local_resort_courses] Starting re-sorting of all categories');

    // Iterate over all categories.
    foreach ($allcategories as $category) {
        // Cron log output.
        mtrace('[local_resort_courses] ... Re-sorting category '.$category->id.' (Path: '.$category->path.' | Name: '.$category->name.')');

        // Sort the category.
        resort_course_category($category, true);
    }

    // End cron log output.
    mtrace('[local_resort_courses] Finished re-sorting of all categories');
}

/**
 * Function to sort a single course category.
 *
 * @param object $category The category to be sorted.
 * @param bool $cronrunning The fact that the re-sorting was triggered by the scheduled task.
 * @return bool
 */
function resort_course_category($category, $cronrunning = false) {
    global $DB;

    // Get plugin config.
    $config = get_config('local_resort_courses');

    // Check if category has to be skipped according to plugin settings.
    if (!empty($config->skipcategories)) {
        $skipcategories = explode(',', $config->skipcategories);
        if (is_array($skipcategories)) {
            if (in_array($category->id, $skipcategories)) {
                // Category has to be skipped.
                // Let's return and leave the category unsorted.
                return true;
            }
        }
    }

    // Check if we skip categories recursively and one of category's parents has to be skipped according to plugin settings.
    if ($config->skipcategoriesrecursively == true) {
        if (is_array($skipcategories)) {
            $parents = explode("/", $category->path);
            foreach ($parents as $p) {
                if (in_array($p, $skipcategories)) {
                    // Category has to be skipped.
                    // Let's return and leave the category unsorted.
                    return true;
                }
            }
        }
    }

    // Set sortorder sql clause.
    switch($config->sortorder) {
        case RESORT_COURSES_SORT_FULLNAME_ASC:
            $sortsql = "lower(c.fullname) ASC";
            break;
        case RESORT_COURSES_SORT_FULLNAME_DESC:
            $sortsql = "lower(c.fullname) DESC";
            break;
        case RESORT_COURSES_SORT_SHORTNAME_ASC:
            $sortsql = "lower(c.shortname) ASC";
            break;
        case RESORT_COURSES_SORT_SHORTNAME_DESC:
            $sortsql = "lower(c.shortname) DESC";
            break;
        case RESORT_COURSES_SORT_COURSEID_ASC:
            $sortsql = "c.idnumber ASC";
            break;
        case RESORT_COURSES_SORT_COURSEID_DESC:
            $sortsql = "c.idnumber DESC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_ASC:
            $sortsql = "c.startdate ASC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_DESC:
            $sortsql = "c.startdate DESC";
            break;
        default:
            $sortsql = "lower(c.fullname) ASC";
    }

    // Re-sort course category.
    // This is a subset of the function core_course_category::resort_courses().
    // We don't directly use this function as
    // a) it was not there when this plugin was built and does not support sorting by startdate unfortunately.
    // b) it does some additional formatting of the course names before sorting which we don't necessarily expect and need.

    // Get courses within category.
    $courses = get_courses($category->id, $sortsql, 'c.id, c.fullname, c.sortorder, c.visible');

    // If there are any courses in the category.
    if (count($courses) > 0) {
        // Do the resorting.
        $i = 1;
        foreach ($courses as $course) {
            $DB->set_field('course', 'sortorder', $category->sortorder + $i, array('id' => $course->id));
            $i++;
        }

        // Cleanup - This should not be needed but we do it just to be safe.
        fix_course_sortorder();
        cache_helper::purge_by_event('changesincourse');

        // Log the event.
        $logevent = \local_resort_courses\event\courses_sorted::create(array(
            'objectid' => $category->id,
            'context' => context_coursecat::instance($category->id),
            'other' => array(
                'cronrunning' => $cronrunning,
            )
        ));
        $logevent->trigger();
    }

    // If we have arrived here, the category should be sorted.
    return true;
}
