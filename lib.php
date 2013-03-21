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
 * @package     local
 * @subpackage  local_resort_courses
 * @copyright   2013 Alexander Bias, University of Ulm <alexander.bias@uni-ulm.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
 * Event handler function
 *
 * @param object $eventdata Event data
 * @return bool
 */
function resort_courses($eventdata) {
    global $DB, $CFG;

    // Get plugin config
    $config = get_config('local_resort_courses');


    // Get category
    $category = $DB->get_record('course_categories', array('id' => $eventdata->category));
    if (!$category) {
        return true; // Now we have an error, but if we return false, the event will stay in the event queue -> let's return and leave the category unsorted
    }

    // Check if category has to be skipped according to plugin settings
    $skipcategories = explode(',', $config->skipcategories);
    if (is_array($skipcategories)) {
        if (in_array($category->id, $skipcategories)) {
            return true; // Category has to be skipped -> let's return and leave the category unsorted
        }
    }

    // Check if we skip categories recursively and one of category's parents has to be skipped according to plugin settings
    if ($config->skipcategoriesrecursively == true) {
        if (is_array($skipcategories)) {
            $parents = explode("/", $category->path);
            foreach ($parents as $p) {
                if (in_array($p, $skipcategories)) {
                    return true; // Category has to be skipped -> let's return and leave the category unsorted
                }
            }
        }
    }


    // Set sortorder sql clause
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
            $sortsql = "lower(c.idnumber) ASC";
            break;
        case RESORT_COURSES_SORT_COURSEID_DESC:
            $sortsql = "lower(c.idnumber) DESC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_ASC:
            $sortsql = "lower(c.startdate) ASC";
            break;
        case RESORT_COURSES_SORT_STARTDATE_DESC:
            $sortsql = "lower(c.startdate) DESC";
            break;
        default:
            $sortsql = "lower(c.fullname) ASC";
    }


    // Re-sort category - borrowed from /course/category.php line 61
    // TODO: category.php now uses asort_objects_by_property(), change sorting method to this method instead of SQL sorting as soon as it becomes necessary for this plugin
    if ($courses = get_courses($category->id, $sortsql, 'c.id,c.fullname,c.sortorder')) {
        $i = 1;
        foreach ($courses as $course) {
            $DB->set_field('course', 'sortorder', $category->sortorder+$i, array('id'=>$course->id));
            $i++;
        }
        fix_course_sortorder(); // should not be needed
    }


    // Log the event
    add_to_log (SITEID, 'local_resort_courses', '', '', $category->name.' ('.$category->id.')');

    return true;
}
