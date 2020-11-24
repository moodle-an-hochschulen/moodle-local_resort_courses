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
 * Local plugin "resort courses" - Language pack
 *
 * @package    local_resort_courses
 * @copyright  2013 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Re-sort Courses';
$string['privacy:metadata'] = 'The re-sort courses plugin provides extended functionality to Moodle admins, but does not store any personal data.';
$string['eventcoursessorted'] = 'Courses re-sorted';
$string['eventcoursessorted_desc'] = 'Courses in category \'{$a}\' were automatically re-sorted after the creation / update of a course in this category';
$string['eventcoursessortedcron_desc'] = 'Courses in category \'{$a}\' were automatically re-sorted within the re-sorting scheduled task';
$string['resorttask'] = 'Re-sort courses in all categories';
$string['skipcategories'] = 'Skip categories';
$string['skipcategories_desc'] = 'Skip these categories when re-sorting';
$string['skipcategoriesrecursively'] = 'Skip categories recursively';
$string['skipcategoriesrecursively_desc'] = 'Skip these categories and all of their children';
$string['sortcourseidasc'] = 'Sort by course ID number, ascending order';
$string['sortcourseiddesc'] = 'Sort by course ID number, descending order';
$string['sortfullnameasc'] = 'Sort by course full name, ascending order';
$string['sortfullnamedesc'] = 'Sort by course full name, descending order';
$string['sortorder'] = 'Sort order';
$string['sortorder_desc'] = 'How should the courses be sorted?';
$string['sortshortnameasc'] = 'Sort by course short name, ascending order';
$string['sortshortnamedesc'] = 'Sort by course short name, descending order';
$string['sortstartdateasc'] = 'Sort by course start date, ascending order';
$string['sortstartdatedesc'] = 'Sort by course start date, descending order';
