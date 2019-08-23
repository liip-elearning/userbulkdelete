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
namespace tool_zhaw_bulkdelete;

defined('MOODLE_INTERNAL') || die();

use core\task\adhoc_task;

class deleteuser_task extends adhoc_task {

    /**
     * @param int $usertodelete
     * @param int|null $curentuser
     * @return deleteuser_task
     */
    public static function create($usertodelete, int $curentuser = null) {
        $task = new self();

        $task->set_custom_data(["userids" => (array) $usertodelete]);
        $task->set_userid($curentuser);
        return $task;
    }

    /**
     * Do the job.
     * Throw exceptions on errors (the job will be retried).
     */
    public function execute() {
        global $DB;
        $data = $this->get_custom_data();
        $userids = $data->userids ?? [];

        if (empty($userids)) {
            debugging("No users set in the task !");
            return;
        }

        list($in, $params) = $DB->get_in_or_equal($userids);
        $rs = $DB->get_recordset_select('user', "deleted = 0 and id $in", $params);

        $errors = [];
        foreach ($rs as $user) {
            if (is_siteadmin($user)) {
                $errors[] = ["reason" => "is_admin", "user" => $user]; // TODO Translate reason.
                continue;
            }
            if ($this->get_userid() == $user->id) {
                $errors[] = ["reason" => "current_user", "user" => $user];// TODO Translate reason.
                continue;
            }
            $result = delete_user($user);
            if (!$result) {
                $errors[] = ["reason" => "failed", "user" => $user];// TODO Translate reason.
            }
        }
        $rs->close();
        foreach ($errors as $error) {
            // TODO Notify user and don't stop on first error.
            $message = sprintf("Unable to delete user %d. Reason %s", $error["user"]->id, $error["reason"]);
            throw new \RuntimeException($message);
        }
    }
}