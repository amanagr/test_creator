<?php

require_once(__DIR__ . '../../../config.php');
require_once($CFG->dirroot . '/question/editlib.php');
require_once(__DIR__ . '/classes/bank.php');

list($thispageurl, $contexts, $cmid, $cm, $module, $pagevars) =
        question_edit_setup('questions', '/question/edit.php');

$url = new moodle_url($thispageurl);
if (($lastchanged = optional_param('lastchanged', 0, PARAM_INT)) !== 0) {
    $url->param('lastchanged', $lastchanged);
}
$PAGE->set_url($url);
global $DB;
$quiz = $DB->get_record('quiz', array('id' => $cm->instance));
$questionbank = new test_creator_bank_view($contexts, $thispageurl, $COURSE, $cm, $quiz);
$questionbank->process_actions();

// TODO log this page view.

$context = $contexts->lowest();
$streditingquestions = get_string('editquestions', 'question');
$PAGE->set_title($streditingquestions);
$PAGE->set_heading($COURSE->fullname);
echo $OUTPUT->header();

// Print horizontal nav if needed.
$renderer = $PAGE->get_renderer('core_question', 'bank');
echo $renderer->extra_horizontal_navigation();

echo '<div class="questionbankwindow boxwidthwide boxaligncenter">';
$questionbank->display('questions', $pagevars['qpage'], $pagevars['qperpage'],
        $pagevars['cat'], $pagevars['recurse'], $pagevars['showhidden'],
        $pagevars['qbshowtext'], $pagevars['qtagids'], $pagevars['qsubjectids']);
echo "</div>\n";

echo $OUTPUT->footer();
