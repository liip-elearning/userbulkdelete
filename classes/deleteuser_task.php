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

use core\message\message;
use core\task\adhoc_task;

class deleteuser_task extends adhoc_task  {

    /**
     * @param int $usertodelete
     * @param int|null $curentuser
     * @return deleteuser_task
     */
    public static function create($usertodelete, int $curentuser = null, $pid) {
        $task = new self();
        $task->set_custom_data(["userid" => (array) $usertodelete, "pid" => $pid]);
        $task->set_userid($curentuser);
        return $task;
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB, $PAGE;
        $data = $this->get_custom_data();
        $userid = $data->userid ?? [];

        if (empty($userid)) {
            debugging("No users set in the task!");
            return;
        }

        list($in, $params) = $DB->get_in_or_equal($userid);
        $rs = $DB->get_recordset_select('user', "deleted = 0 and id $in", $params);

        $errors = [];
        foreach ($rs as $user) {
            $result = delete_user($user);
            if (!$result) {
                $errors[] = ["reason" => "unknown", "user" => $user];
            }
        }
        $rs->close();
        foreach ($errors as $error) {

            // In case of failure, we just save the related info on the DB in order to generate the final report.
            $failuredetails = new \stdClass();
            $failuredetails->timestamp = $data->pid;
            $failuredetails->userid = $error["user"]->id;
            $DB->insert_record('tool_userbulkdelete_failures', $failuredetails);

            // Logging.
            $details = new \stdClass();
            $details->userid = $error["user"]->id;
            $details->username = $error["user"]->firstname.' '.$error["user"]->lastname;
            $details->pid = $data->pid;
            $event = \tool_userbulkdelete\event\deleteuser_error::create(array(
                'context' => $PAGE->context,
                'relateduserid' => $error["user"]->id,
                'other' => ["username" => $details->username, "pid" => $data->pid]
            ));
            $event->trigger();

            // Throwing the error so the adhoc task fails successfully ;) !
            $exceptionmessage = get_string('exceptionuserdeletion', 'tool_userbulkdelete', $details);
            throw new \RuntimeException($exceptionmessage);
        }
    }
}
