<?php

require_once('../../config.php');
global $DB,$CFG;

// Check for all required variables.
// $courseid = required_param('courseid', PARAM_INT);
$quiz_name = optional_param('name','Name',PARAM_RAW);
// $quiz = new stdClass();
// $quiz->name = $quiz_name;
// $quiz->intro = '';
// $quiz->course = 2;
// $quiz->introformat = 1;
// $quiz->overduehandling = 'autosubmit';
// $quiz->preferredbehaviour = 'deferredfeedback';
// $quiz->reviewattempt=69888;
// $quiz->reviewcorrectness=4352;
// $quiz->reviewmarks=4352;
// $quiz->reviewspecificfeedaback=4352;
// $quiz->reviewgeneralfeedback=4352;
// $quiz->reviewrightanswer=4352;
// $quiz->reviewoverallfeedback=4352;
// $quiz->questionsperpage=1;
// $quiz->timemodified=time();
// $quiz->timecreated=time();
require_once($CFG->dirroot.'/course/modlib.php');

$course = get_course(2);

$data = (object)array(
	'name' => $quiz_name,
	'intro' => 'Hello world	',
	'course' => 2,
	'introformat' => 1,
	'visible' => 1,
	'overduehandling' => 'autosubmit',
	'preferredbehaviour' => 'deferredfeedback',
	'timemodified' => time(),
	'quizpassword' => '',
	'timeopen' => 0,
	'timeclose' => 0,
	'grade' => 0,
	'questiondecimalpoints' => 2,
	'timecreated' => time(),
	'module' =>  $DB->get_field('modules', 'id', array('name' => 'quiz')),
	'modulename' => 'quiz',
	'section' => 1,
	'cmidnumber' => '',
	'groupmode' => NOGROUPS,
	'groupingid' => 0,
	'availability' => null,
	'timelimit' => 180*60,
	'completion' => 0,
);

$date = new DateTime("now", core_date::get_user_timezone_object());
$date->setTime(9, 0, 0);
$data->timeopen = $date->getTimestamp();
$date->setTime(12, 0, 0);
$data->timeclose = $date->getTimestamp(); 

$moduleinfo = add_moduleinfo($data, $course);
// if (!$course = $DB->get_record('course', array('id' => $courseid))) {
//     print_error('invalidcourse', 'block_test_creator', $courseid);
// }
// require_login($course);

// $quiz->id = $DB->insert_record('quiz', $quiz);
// $course_module = new stdClass();
// $course_module->module=16;
// //$course_module->course=0;
// $course_module->instance = $quiz->id;
// $course_module->course=2;
// $course_module->section=1;
// $course_module->id = $DB->insert_record('course_modules', $course_module);
// $sequence = $DB->get_record('course_sections', array('id' => 1))->sequence;
// $sequence.=",$course_module->id";
// $DB->set_field('course_sections', 'sequence', $sequence, ['id' => 1]);
// print_object($course_module);
//  die();
// print_object($moduleinfo);
// die();
$returnurl = new moodle_url("/blocks/test_creator/question_bank_view.php?cmid=$moduleinfo->coursemodule");
//$returnurl->param('moduleinfo',$moduleinfo);
// print_object($returnurl);
// die();
//http://localhost:8888/moodle/question/edit.php?cmid=3
global $PAGE;
// $course = $DB->get_record('course', array('id' => $course_module->course), '*', MUST_EXIST);
// $cm = get_coursemodule_from_instance('quiz', $quiz->id);
$PAGE->set_url($returnurl);
// print_object($course_module);
// die();
// $course_module->id));
// $course = $DB->get_record('course', array('id' => $course->id));
// $info = get_fast_modinfo($course);
// print_object($info);
// die();
// require_login($course, false, $course_module);
// $quizcontext = \context_module::instance($course_module->id);
// $PAGE->set_context(context_module::instance($quiz->id));
// $PAGE->set_cm($course_module, $course, $quiz);


redirect($returnurl);
// $test_creator = new test_creator_form();

// $test_creator->display();
?>
