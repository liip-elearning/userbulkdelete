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
 * Strings for component 'tool_userbulkdelete', language 'de'
 *
 * @package    tool_userbulkdelete
 * @copyright  2019 Liip
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['privacy:metadata'] = 'Das Bulk Delete Plugin speichert keine personenbezogenen Daten.';
$string['eventdeleteuser_error'] = 'Löschen fehlgeschlagen';
$string['pluginname'] = 'Mehrer Benutzer auf einmal löschen';
$string['menu'] = 'Mehrer Benutzer auf einmal löschen';
$string['messageprovider:tasks_status'] = 'Statusmeldungen erhalten für das Löschen von mehreren Benutzer/innen';
$string['getbacklink'] = 'Zurück zum Bulk-Prozess';
$string['getnoselection'] = 'Sie müssen zunächst eine Auswahl aus dem Bulk User Tool zur Verfügung stellen.';
$string['gettitle'] = 'Folgende Benutzer werden für das asynchrone Löschen eingeplant';
$string['getscheduleimpossible'] = '{$a} Benutzer können nicht gelöscht werden und werden nicht in den Prozess einbezogen.';
$string['getschedulepossible'] = '{$a} Benutzer werden zum Löschen eingeplant.';
$string['cannotdeleteadmin'] = 'Ein Administratorkonto und der aktuelle Benutzer können nicht gelöscht werden.';
$string['getsuccessmsg'] = '{$a} Benutzer wurden zum Löschen eingeplant.';
$string['getdolink'] = 'Asynchrones Löschen starten';
$string['canbedeleted'] = 'Kann gelöscht werden';
$string['userdeletionfailed'] = 'Fehler: Das asynchrone Löschen des Benutzers {$a->username} ist fehlgeschlagen.';
$string['userdeletionfailedhtml'] = 'Hoppla!<br />
Die asynchrone Benutzerlöschaufgabe für {$a->username} ist fehlgeschlagen, sie wird erneut versucht und schließlich gelöscht.<br />
Sie können auch versuchen, das Konto manuell zu löschen.<br />
Prozess-ID = {$a->pid}.';
$string['exceptionuserdeletion'] = 'Benutzer mit der ID {$a->userid} kann nicht gelöscht werden. Prozess-ID  = {$a->pid}';
$string['bulksuccesssubject'] = 'Erfolg: Die Benutzer wurden erfolgreich gelöscht';
$string['bulksuccesshtml'] = 'Alle asynchronen Benutzerlöschaufgaben, die mit {$a->start} gestartet wurden, wurden bearbeitet.<br />
Gelöschte Benutzer = {$a->deletioncount}/{$a->deletioncount}<br />
Prozess-ID = {$a->pid}.';
$string['bulkfailsubject'] = 'Fehler: Löschen von Benutzern ist fehlgeschlagen.';
$string['bulkfailshtml'] = 'Hoppla! <br />
{$a->inqueue}/{$a->deletioncount} der asynchronen Benutzerlöschaufgaben, die mit {$a->start} gestartet wurden, sind fehlgeschlagen, sie werden später erneut versucht.<br /><br />
Prozess-ID = {$a->pid}<br /><br />
Benutzerdetails<br />
============================================<br />';
$string['bulkfailshtmluserinfo'] = '{$a->fullname} <a href="{$a->wwwroot}/user/view.php?id={$a->userid}" target="_blank">[Benutzerprofil anzeigen]</a><br />';
$string['exceptionbulkfail'] = 'Die Löschaufgaben mit id = {$a->pid} sind noch nicht abgeschlossen.';