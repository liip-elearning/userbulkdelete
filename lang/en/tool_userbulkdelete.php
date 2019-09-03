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
 * Strings for component 'tool_xmldb', language 'en', branch 'MOODLE_22_STABLE'
 *
 * @package    tool_xmldb
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['privacy:metadata'] = 'The bulk delete plugin does not store any personal data.';
$string['eventdeleteuser_error'] = 'Deletion failed';
$string['pluginname'] = 'Bulk asynchronous user deletion';
$string['menu'] = 'Bulk asynchronous user deletion';
$string['messageprovider:tasks_status'] = 'Receive status messages for the bulk deletion of users';
$string['getbacklink'] = 'Back to Bulk action';
$string['getnoselection'] = 'You must provide a selection from the bulk user tool first.';
$string['gettitle'] = 'The following users will be scheduled for asynchronous deletion';
$string['getscheduleimpossible'] = '{$a} user(s) can not be deleted and will not be included in the process.';
$string['getschedulepossible'] = '{$a} user(s) will be scheduled for deletion.';
$string['cannotdeleteadmin'] = 'Cannot delete an administrator account nor the current user.';
$string['getsuccessmsg'] = '{$a} user(s) have been scheduled to be deleted';
$string['getdolink'] = 'Start asynchronous deletion';
$string['canbedeleted'] = 'Can be deleted';
$string['userdeletionfailed'] = 'Error: The asynchronous deletion of user {$a->username} failed';
$string['userdeletionfailedhtml'] = 'Ooops!<br />
The async user deletion task for {$a->username} has failed, it will be attempted again and eventually dropped.<br />
You can also try to delete the account manually.<br />
Process id = {$a->pid}.';
$string['exceptionuserdeletion'] = 'Unable to delete user with id {$a->userid}. Reason: {$a->reason}';
$string['bulksuccesssubject'] = 'Success: Bulk asynchronous deletion of users completed';
$string['bulksuccesshtml'] = 'Greetings!<br />
All of the async user deletion tasks started on {$a->start} have been processed.<br />
Deleted users = {$a->deletioncount}/{$a->deletioncount}<br />
Process id = {$a->pid}';
$string['bulkfailsubject'] = 'Fail: Bulk asynchronous deletion of users failed';
$string['bulkfailshtml'] = 'Ooops!<br />
{$a->inqueue}/{$a->deletioncount} of the async user deletion tasks started on {$a->start} have failed, they will be tried again later.<br />
Process id = {$a->pid}';
$string['exceptionbulkfail'] = 'The deletion tasks with id = {$a->pid} have not yet been completed.';
$string['blockcontenttext'] = 'When a large amount of users have been selected for deletion, the tasks will be executed asynchronously in the background to avoid server timeout issues.';
$string['blockcontentbutton'] = 'Perform Bulk Async Deletion';