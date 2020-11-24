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
 * Local plugin "resort courses" - Event definition
 *
 * @package    local_resort_courses
 * @copyright  2013 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_resort_courses\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The local_resort_courses courses sorted event class.
 *
 * @package    local_resort_courses
 * @copyright  2013 Alexander Bias, Ulm University <alexander.bias@uni-ulm.de>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class courses_sorted extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'course';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursessorted', 'local_resort_courses');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        if ($this->other['cronrunning'] == true) {
            return get_string('eventcoursessortedcron_desc', 'local_resort_courses', $this->objectid);
        } else {
            return get_string('eventcoursessorted_desc', 'local_resort_courses', $this->objectid);
        }
    }

    /**
     * Get url related to the action.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/course/index.php', array('categoryid' => $this->objectid));
    }
}
