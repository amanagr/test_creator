<?php
require_once(__DIR__.'/../../../mod/quiz/locallib.php');
require_once(__DIR__.'/search/difficulty_condition.php');
require_once(__DIR__.'/search/subject_condition.php');
class test_creator_bank_view extends \mod_quiz\question\bank\custom_view{

    /**
     * Display the form with options for which questions are displayed and how they are displayed.
     * @param bool $showquestiontext Display the text of the question within the list.
     * @param string $path path to the script displaying this page.
     * @param bool $showtextoption whether to include the 'Show question text' checkbox.
     */
    protected function display_options_form($showquestiontext, $scriptpath = '/blocks/test_creator/question_bank_view.php',
            $showtextoption = true) {
        global $PAGE;

        echo \html_writer::start_tag('form', array('method' => 'get',
                'action' => new \moodle_url($scriptpath), 'id' => 'displayoptions'));
        echo \html_writer::start_div();

        $excludes = array('recurse', 'showhidden', 'qbshowtext');
        // If the URL contains any tags then we need to prevent them
        // being added to the form as hidden elements because the tags
        // are managed separately.
        if ($this->baseurl->param('qtagids[0]')) {
            $index = 0;
            while ($this->baseurl->param("qtagids[{$index}]")) {
                $excludes[] = "qtagids[{$index}]";
                $index++;
            }
        }
        echo \html_writer::input_hidden_params($this->baseurl, $excludes);

        $this->searchconditions = array(new \core_question\bank\search\difficulty_condition(),new \core_question\bank\search\subject_condition());

        foreach ($this->searchconditions as $searchcondition) {
            echo $searchcondition->display_options($this);
        }
        // if ($showtextoption) {
        //     $this->display_showtext_checkbox($showquestiontext);
        // }
        $this->display_advanced_search_form();
        $go = \html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('go')));
        echo \html_writer::tag('noscript', \html_writer::div($go), array('class' => 'inline'));
        echo \html_writer::end_div();
        echo \html_writer::end_tag('form');
        $PAGE->requires->yui_module('moodle-question-searchform', 'M.question.searchform.init');
    }

}
