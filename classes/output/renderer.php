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
 * @package tool_userbulkdelete\output
 * TODO Translate.
 */
class renderer extends plugin_renderer_base {
    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_no_selection() {

        return $this->output->notification("You must provide a selection from the bulk user tool first.") .
                $this->get_backlink();
    }

    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_backlink() {
        return html_writer::link(new moodle_url("/admin/user/user_bulk.php"), "Back to Bulk action",
                ["class" => 'btn btn-secondary']);
    }

    /**
     * @return string
     */
    public function get_title() {
        return html_writer::tag("h2", "The following users will be deleted");
    }

    /**
     * @param object[] $errors List of failed users records.
     * @return string
     */
    public function get_errors(array $errors) {
        if (empty($errors)) {
            return '';
        }
        return html_writer::tag("p", sprintf("%d user(s) can not be deleted.", count($errors)));
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
        return $this->output->pix_icon('i/warning', "Cannot delete an administrator account nor the current user", '',
                array('class' => 'iconsmall text-danger'));
    }

    /**
     * @param int $number
     * @return string
     */
    public function get_success_message(int $number) {
        return html_writer::tag("h2", sprintf("%d user(s) have been scheduled to be deleted", $number));
    }

    /**
     * @return string
     * @throws \moodle_exception
     */
    public function get_dolink() {
        return html_writer::link(new moodle_url($this->page->url, ["sesskey" => sesskey(), "action" => "delete"]), "Delete",
                ["class" => 'btn btn-primary']);
    }

}
