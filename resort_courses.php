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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	 See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die;

function resort_courses($eventdata) {
	global $DB, $CFG;

	// Get category
	$category = $DB->get_record('course_categories', array('id' => $eventdata->category));
	if (!$category) {
		return true; // Now we have an error, but if we return false, the event will stay in the event queue -> let's return and leave the category unsorted
	}

	// Check if category has to be skipped according to $CFG->resort_courses_skip
	if (is_array($CFG->resort_courses_skip)) {
		$parents = explode("/", $category->path);
		foreach ($parents as $p) {
			if (in_array($p, $CFG->resort_courses_skip)) {
				return true; // Category has to be skipped -> let's return and leave the category unsorted
			}
		}
	}

	// Check sortorder syntax
	if ($CFG->resort_courses_sortorder) {
		if ($CFG->resort_courses_sortorder != "fullname ASC" &&
			$CFG->resort_courses_sortorder != "fullname DESC" &&
			$CFG->resort_courses_sortorder != "shortname ASC" &&
			$CFG->resort_courses_sortorder != "shortname DESC" &&
			$CFG->resort_courses_sortorder != "idnumber ASC" &&
			$CFG->resort_courses_sortorder != "idnumber DESC") {
				return true; // now we have an error again -> let's return and leave the category unsorted
		}
	}

	// Resort category - copied from /course/category.php line 61 - slightly changed
	if ($courses = get_courses($category->id, $CFG->resort_courses_sortorder, 'c.id,c.fullname,c.sortorder')) {
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
