<?php
require_once(__DIR__.'/../../../mod/quiz/locallib.php');
require_once(__DIR__.'/search/difficulty_condition.php');
require_once(__DIR__.'/search/subject_condition.php');
class test_creator_bank_view extends \mod_quiz\question\bank\custom_view{

    public function display($tabname, $page, $perpage, $cat,
            $recurse, $showhidden, $showquestiontext, $tagids = [], $subjectids = []) {
        global $PAGE;

        if ($this->process_actions_needing_ui()) {
            return;
        }
        $editcontexts = $this->contexts->having_one_edit_tab_cap($tabname);
        list($categoryid, $contextid) = explode(',', $cat);
        $catcontext = \context::instance_by_id($contextid);
        $thiscontext = $this->get_most_specific_context();
        // Category selection form.
        $this->display_question_bank_header();
        array_unshift($this->searchconditions, new \core_question\bank\search\difficulty_condition($tagids));
        array_unshift($this->searchconditions, new \core_question\bank\search\subject_condition($subjectids));
        $this->display_options_form($showquestiontext);

        // Continues with list of questions.
        $this->display_question_list($editcontexts,
                $this->baseurl, $cat, $this->cm,
                null, $page, $perpage, $showhidden, $showquestiontext,
                $this->contexts->having_cap('moodle/question:add'));

        $PAGE->requires->js_call_amd('core_question/edit_tags', 'init', ['#questionscontainer']);
    }

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
        if ($this->baseurl->param('qsubjectids[0]')) {
            $index = 0;
            while ($this->baseurl->param("qsubjectids[{$index}]")) {
                $excludes[] = "qsubjectids[{$index}]";
                $index++;
            }
        }
        echo \html_writer::input_hidden_params($this->baseurl, $excludes);


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
