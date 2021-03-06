<?php
/**
 * ELIS(TM): Enterprise Learning Intelligence Suite
 * Copyright (C) 2008-2013 Remote-Learner.net Inc (http://www.remote-learner.net)
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
 * @package    local_elisprogram
 * @author     Remote-Learner.net Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright  (C) 2008-2013 Remote Learner.net Inc http://www.remote-learner.net
 *
 */

require_once(dirname(__FILE__).'/../../eliscore/test_config.php');
global $CFG;
require_once($CFG->dirroot.'/local/elisprogram/lib/setup.php');

// Data objects.
require_once(elispm::lib('data/curriculumcourse.class.php'));

/**
 * Test coursecorequisite dataobject.
 * Since class isdefined within curriculumcourse.class.php testDataObjectsFieldsAndAssociations.php will not auto test this class.
 * @group local_elisprogram
 */
class coursecorequisite_testcase extends elis_database_test {

    /**
     * Load initial data from CSVs.
     */
    protected function load_csv_data() {
        $dataset = $this->createCsvDataSet(array(
            coursecorequisite::TABLE => elispm::file('tests/fixtures/course_corequisite.csv')
        ));
        $this->loadDataSet($dataset);
    }

    /**
     * Test that data class has correct DB fields.
     */
    public function test_coursecorequisite_hascorrectdbfields() {
        $testobj = new coursecorequisite(false, null, array(), false, array());
        $this->assertTrue($testobj->_test_dbfields(), 'Error(s) with class $_dbfield_ properties.');
    }

    /**
     * Test that data class has correct associations.
     */
    public function test_coursecorequisite_hascorrectassociations() {
        $testobj = new coursecorequisite(false, null, array(), false, array());
        $this->assertTrue($testobj->_test_associations(), 'Error(s) with class associations.');
    }

    /**
     * Test that a record can be created in the database.
     */
    public function test_coursecorequisite_cancreaterecord() {
        // Create a record.
        $src = new coursecorequisite();
        $src->curriculumcourseid = 1;
        $src->courseid = 2;
        $src->save();

        // Read it back.
        $retr = new coursecorequisite($src->id, null, array(), false, array());
        foreach ($src as $key => $value) {
            if (strpos($key, elis_data_object::FIELD_PREFIX) !== false) {
                $key = substr($key, strlen(elis_data_object::FIELD_PREFIX));
                $this->assertEquals($src->{$key}, $retr->{$key});
            }
        }
    }

    /**
     * Test that a record can be modified.
     */
    public function test_coursecorequisite_canupdaterecord() {
        $this->load_csv_data();

        // Read a record.
        $src = new coursecorequisite(1, null, array(), false, array());
        $src->courseid = 4;
        $src->save();

        // Read it back.
        $retr = new coursecorequisite(3, null, array(), false, array());
        foreach ($src as $key => $value) {
            if (strpos($key, elis_data_object::FIELD_PREFIX) !== false) {
                $key = substr($key, strlen(elis_data_object::FIELD_PREFIX));
                $this->assertEquals($src->{$key}, $retr->{$key});
            }
        }
    }
}