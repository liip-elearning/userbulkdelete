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
 * The deleteuser_failed event.
 *
 * @package    tool_userbulkdelete
 * @copyright  2019 Liip
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_userbulkdelete\event;

defined('MOODLE_INTERNAL') || die();
/**
 * The deleteduser_failed event class.
 * @since     Moodle 3.6
 * @copyright 2019 Liip
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 **/
class deleteuser_error extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    public static function get_name() {
        return get_string('eventdeleteuser_error', 'tool_userbulkdelete');
    }

    public function get_description() {
        // We intentionally keep this log entry in English.
        return "The user {$this->other['username']} could not be deleted. Process id = {$this->other['pid']} ";
    }

}