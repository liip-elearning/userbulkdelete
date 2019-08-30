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
namespace tool_userbulkdelete\output;

defined('MOODLE_INTERNAL') || die();

use html_writer;
use moodle_url;
use plugin_renderer_base;

/**
 * Class renderer
 *
 * @package    tool_userbulkdelete
 * @copyright  2019 Liip
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_no_selection() {

        return $this->output->notification(get_string('getnoselection', 'tool_userbulkdelete')) .
                $this->get_backlink();
    }

    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_backlink() {
        return html_writer::link(new moodle_url("/admin/user/user_bulk.php"),
            get_string('getbacklink', 'tool_userbulkdelete'),
                ["class" => 'btn btn-secondary']);
    }

    /**
     * @return string
     */
    public function get_title() {
        return html_writer::tag("h2", get_string('gettitle', 'tool_userbulkdelete'));
    }

    /**
     * @param int $errors List of failed users records.
     * @return string
     */
    public function get_scheduleimpossible(int $quantity) {
        if ($quantity == 0) {
            return '';
        }
        return html_writer::tag("p", $this->get_failed_picto().' '.get_string('getscheduleimpossible',
                'tool_userbulkdelete', (string)$quantity));
    }

    /**
     * @param object[] $errors List of failed users records.
     * @return string
     */
    public function get_schedulepossible(int $quantity) {
        if ($quantity == 0) {
            return '';
        }
        return html_writer::tag("p", $this->get_ok_picto().' '.get_string('getschedulepossible',
                'tool_userbulkdelete', (string)$quantity));
    }

    /**
     * @return string
     */
    public function get_ok_picto() {
        return $this->output->pix_icon('t/check', "OK", '', array('class' => 'iconsmall text-success'));
    }

    /**
     * @return string
     */
    public function get_failed_picto() {
        return $this->output->pix_icon('i/warning', get_string('cannotdeleteadmin', 'tool_userbulkdelete'), '',
                array('class' => 'iconsmall text-danger'));
    }

    /**
     * @param int $number
     * @return string
     */
    public function get_success_message(int $number) {
        return html_writer::tag("h2", get_string('getsuccessmsg', 'tool_userbulkdelete', $number));
    }

    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_dolink() {
        return html_writer::link(new moodle_url($this->page->url, ["sesskey" => sesskey(), "action" => "delete"]),
            get_string('getdolink', 'tool_userbulkdelete'),
                ["class" => 'btn btn-primary']);
    }

}
