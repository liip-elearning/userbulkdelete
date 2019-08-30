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
        $inqueue = $DB->count_records_select('task_adhoc', "classname = :class and customdata like :pid", $params, $countitem = "COUNT('id')");

        $message = new message();
        $message->component         = 'tool_userbulkdelete';
        $message->userfrom          = \core_user::get_noreply_user();
        $message->userto            = $data->owner;
        $message->notification      = 1; // This is only set to 0 for personal messages between users.
        $message->smallmessage      = '';
        $message->fullmessageformat = FORMAT_HTML;
        $message->name              = 'tasks_status';

        if (!$inqueue) {
            $message->subject           = 'Success: Bulk asynchronous deletion of users completed'; // TRANSLATE.
            $message->fullmessagehtml   = 'Greetings! <br />All of the async user deletion tasks started on '.date('d/m/Y - H:i:s', $pid) .' have been processed. <br />Deleted users = '.$data->deletioncount.'/'.$data->deletioncount.'<br />Process id = '.$pid;

            message_send($message);
        } else {
            $message->subject           = 'Fail: Bulk asynchronous deletion of users failed'; // TRANSLATE.
            $message->fullmessagehtml   = 'Ooops! <br />'.$inqueue.'/'.$data->deletioncount.' of the async user deletion tasks started on '.date('d/m/Y - H:i:s', $pid) .' have failed, they will be tried again later.<br /> Process id = '.$pid;
            message_send($message);
            $exceptionmessage = sprintf("The deletion tasks with id = %s have not yet been completed.", $pid);
            throw new \RuntimeException($exceptionmessage);
        }
    }
}
