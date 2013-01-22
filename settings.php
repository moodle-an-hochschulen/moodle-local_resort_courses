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

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/lib.php');

if ($hassiteconfig) {
	// New settings page
	$page = new admin_settingpage('resort_courses', get_string('pluginname', 'local_resort_courses'));


	// Sort order
	$page->add(new admin_setting_heading('local_resort_courses/sortorderheading', get_string('sortorder', 'local_resort_courses'), ''));

	// Create sort order widget
	$sortorders[SORT_FULLNAME_ASC] = get_string('sortfullnameasc', 'local_resort_courses');
	$sortorders[SORT_FULLNAME_DESC] = get_string('sortfullnamedesc', 'local_resort_courses');
	$sortorders[SORT_SHORTNAME_ASC] = get_string('sortshortnameasc', 'local_resort_courses');
	$sortorders[SORT_SHORTNAME_DESC] = get_string('sortshortnamedesc', 'local_resort_courses');
	$sortorders[SORT_COURSEID_ASC] = get_string('sortcourseidasc', 'local_resort_courses');
	$sortorders[SORT_COURSEID_DESC] = get_string('sortcourseiddesc', 'local_resort_courses');
	$sortorders[SORT_STARTDATE_ASC] = get_string('sortstartdateasc', 'local_resort_courses');
	$sortorders[SORT_STARTDATE_DESC] = get_string('sortstartdatedesc', 'local_resort_courses');
	$page->add(new admin_setting_configselect('local_resort_courses/sortorder', get_string('sortorder', 'local_resort_courses'), get_string('sortorderdescription', 'local_resort_courses'), SORT_FULLNAME_ASC, $sortorders));


	// Skip categories
	$page->add(new admin_setting_heading('local_resort_courses/skipcategoriesheading', get_string('skipcategories', 'local_resort_courses'), ''));

	// Create skip categories widget
	require_once($CFG->dirroot.'/course/lib.php');
	$categories = make_categories_options();
	$page->add(new admin_setting_configmultiselect('local_resort_courses/skipcategories', get_string('skipcategories', 'local_resort_courses'), get_string('skipcategoriesdescription', 'local_resort_courses'), null, $categories));

	// Create skip categories recursively widget
	$page->add(new admin_setting_configcheckbox('local_resort_courses/skipcategoriesrecursively', get_string('skipcategoriesrecursively', 'local_resort_courses'), get_string('skipcategoriesrecursivelydescription', 'local_resort_courses'), 0));


	// Add settings page to navigation tree
    $ADMIN->add('localplugins', $page);
}
