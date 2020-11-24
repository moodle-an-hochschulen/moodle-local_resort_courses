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
 * Local plugin "resort courses" - Task definition
 *
 * @package    local_resort_courses
 * @copyright  2020 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_resort_courses\task;

defined('MOODLE_INTERNAL') || die;

/**
 * The local_resort_courses scheduled task class for re-sorting all courses in all categories.
 *
 * @package    local_resort_courses
 * @copyright  2020 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class resort_courses extends \core\task\scheduled_task {

    /**
     * Return localised task name.
     *
     * @return string
     */
    public function get_name() {
        return get_string('resorttask', 'local_resort_courses');
    }

    /**
     * Execute scheduled task.
     *
     * @return boolean
     */
    public function execute() {
        global $CFG;
        require_once($CFG->dirroot.'/local/resort_courses/locallib.php');
        resort_courses_cron();

        // Return true in any case as this plugin does not really have any error handling if a category could not be sorted.
        return true;
    }
}
