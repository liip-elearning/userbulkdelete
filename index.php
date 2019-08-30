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

use core\task\manager;
use tool_userbulkdelete\deleteuser_task;
use tool_userbulkdelete\queuecompletion_task;

require_once('../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$confirm = optional_param('confirm', 0, PARAM_BOOL);

require_login();
admin_externalpage_setup('userbulkdelete');
require_capability('moodle/user:delete', context_system::instance());

/** @var \tool_userbulkdelete\output\renderer $renderer */
$renderer = $PAGE->get_renderer("tool_userbulkdelete");

$execute = optional_param("action", "preview", PARAM_ALPHA) === "delete" and confirm_sesskey();

$PAGE->set_button($renderer->get_backlink());

echo $OUTPUT->header();

if ($execute) {
    // Do the deletion.
    list($in, $params) = $DB->get_in_or_equal($SESSION->bulk_users);
    $rs = $DB->get_recordset_select('user', "deleted = 0 and id $in", $params);
    $pid = time();
    $deletioncount = 0;
    foreach ($rs as $user) {
        if (!is_siteadmin($user) and $USER->id != $user->id) {
            $task = deleteuser_task::create($user->id, $USER->id, $pid);
            manager::queue_adhoc_task($task);
            $deletioncount++;
        } else {
            // Remove the siteadmin and the currentuser from the session.
            unset($SESSION->bulk_users[$user->id]);
        }
    }
    echo $renderer->get_success_message($deletioncount);
    if ($deletioncount) {
        $notificationtask = queuecompletion_task::create($pid, $USER->id, $deletioncount);
        manager::queue_adhoc_task($notificationtask);
    }
    unset($SESSION->bulk_users);

} else {
    // Preview.

    // Only create the query if we have a selection.
    if (!empty($SESSION->bulk_users)) {
        list($in, $params) = $DB->get_in_or_equal($SESSION->bulk_users);
        $rs = $DB->get_recordset_select('user', "deleted = 0 and id $in", $params);
    } else {
        $rs = [];
        $empty = true;
    }

    // Table output.
    $table = new html_table();
    $table->head = [
            'id',
            get_string('fullname'),
            get_string('email'),
            'Can be deleted'
    ]; // TODO Translate.
    $table->size = ['3%', '47%', '50%'];
    $table->align = ['left'];
    $table->data = [];

    $errors = [];
    $empty = true;
    foreach ($rs as $user) {
        $empty = false;
        $canbedeleted = !is_siteadmin($user) && $USER->id != $user->id;
        $table->data[] = [
                $user->id,
                $user->firstname.' '.$user->lastname,
                $user->email,
                $canbedeleted ? $renderer->get_ok_picto() : $renderer->get_failed_picto()
        ];
        if (!$canbedeleted) {
            $errors[] = $user;
        }
    }

    if ($rs !== []) {
        $rs->close();
    }

    if (!$empty) {
        echo $renderer->get_title();
        echo html_writer::table($table);
        echo $renderer->get_errors($errors);
        echo $renderer->get_dolink();
    } else {
        echo $renderer->get_no_selection();
    }
}

echo $OUTPUT->footer();