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
defined('MOODLE_INTERNAL') || die();

/**
 * tool_userbulkdelete
 *
 * @package    tool_userbulkdelete
 */
function xmldb_tool_userbulkdelete_upgrade($oldversion) {
    global $CFG, $DB;
    $dbman = $DB->get_manager();

    $result = true;

    if ($oldversion < 2019090400) {

        // Define table tool_userbulkdelete_failures to be created.
        $table = new xmldb_table('tool_userbulkdelete_failures');

        // Adding fields to table tool_userbulkdelete_failures.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timestamp', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table tool_userbulkdelete_failures.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for tool_userbulkdelete_failures.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Userbulkdelete savepoint reached.
        upgrade_plugin_savepoint(true, 2019090400, 'tool', 'userbulkdelete');
    }

    return $result;

}