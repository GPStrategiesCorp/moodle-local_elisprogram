<?php
/**
 * ELIS(TM): Enterprise Learning Intelligence Suite
 * Copyright (C) 2008-2014 Remote-Learner.net Inc (http://www.remote-learner.net)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    usetenrol_moodleprofile
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2008-2014 Remote-Learner.net Inc (http://www.remote-learner.net)
 *
 */

defined('MOODLE_INTERNAL') || die();

function xmldb_usetenrol_moodleprofile_upgrade($oldversion = 0) {
    global $CFG, $DB;
    $result = true;

    if ($oldversion < 2014030703) {
        require_once($CFG->dirroot.'/local/elisprogram/lib/data/clusterassignment.class.php');
        // Fix plugin name.
        $sql = "UPDATE {".clusterassignment::TABLE."} SET plugin = 'moodleprofile'
                 WHERE plugin = 'moodle_profile'";
        $DB->execute($sql);

        // Filter any duplicates.
        $sql = 'DELETE {'.clusterassignment::TABLE.'}
                   FROM {'.clusterassignment::TABLE.'}
        LEFT OUTER JOIN (SELECT MIN(id) as id, clusterid, userid, plugin, autoenrol
                           FROM {'.clusterassignment::TABLE.'}
                       GROUP BY clusterid, userid, plugin, autoenrol) as KeepRows ON {'.clusterassignment::TABLE.'}.id = KeepRows.id
                  WHERE KeepRows.id IS NULL';
        $DB->execute($sql);

        // Userset enrol savepoint reached.
        upgrade_plugin_savepoint(true, 2014030703, 'usetenrol', 'moodleprofile');
    }

    return $result;
}
