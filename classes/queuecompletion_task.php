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
namespace tool_userbulkdelete;

defined('MOODLE_INTERNAL') || die();

use core\task\adhoc_task;
use core\message\message;

class queuecompletion_task extends adhoc_task {

    /**
     * @param int $pid
     * @return queuecompletion_task
     */
    public static function create($pid, $owner, $count) {
        $task = new self();
        $task->set_custom_data(["pid" => $pid, "owner" => $owner, "deletioncount" => $count]);
        return $task;
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        // Check that no deletion task with PID exists.
        global $DB;
        $data = $this->get_custom_data();
        $pid = $data->pid;
        $params = ["class" => '\tool_userbulkdelete\deleteuser_task', "pid" => '%'.$pid.'%'];
        $inqueue = $DB->count_records_select('task_adhoc', "classname = :class and customdata like :pid",
            $params, $countitem = "COUNT('id')");

        // Common message properties.
        $message = new message();
        $message->component         = 'tool_userbulkdelete';
        $message->userfrom          = \core_user::get_noreply_user();
        $message->userto            = $data->owner;
        $message->notification      = 1; // This is only set to 0 for personal messages between users.
        $message->smallmessage      = '';
        $message->fullmessageformat = FORMAT_HTML;
        $message->name              = 'tasks_status';

        // Process details for the string manipulation.
        $details = new \stdClass();
        $details->start = date('d/m/Y - H:i:s', $pid);
        $details->deletioncount = $data->deletioncount;
        $details->pid = $pid;
        $details->inqueue = $inqueue;

        if (!$inqueue) {
            $message->subject           = get_string('bulksuccesssubject', 'tool_userbulkdelete');
            $message->fullmessagehtml   = get_string('bulksuccesshtml', 'tool_userbulkdelete', $details);
            message_send($message);
        } else {
            $message->subject           = get_string('bulkfailsubject', 'tool_userbulkdelete');
            $message->fullmessagehtml   = get_string('bulkfailshtml', 'tool_userbulkdelete', $details);
            message_send($message);
            $exceptionmessage = get_string('exceptionbulkfail', 'tool_userbulkdelete', $details);
            throw new \RuntimeException($exceptionmessage);
        }
    }
}
