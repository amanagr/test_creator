<?php
 
require_once('../../config.php');
require_once('test_creator_form.php');
 
global $DB;
 
// Check for all required variables.
// $courseid = required_param('courseid', PARAM_INT);
$courseid = 1; 
$quiz_name = required_param('name', PARAM_RAW);
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_test_creator', $courseid);
}
 
require_login($course);
 
$test_creator = new test_creator_form();
 
$test_creator->display();
?>
