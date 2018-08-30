<?php
require_once(__DIR__.'/../../../mod/quiz/locallib.php');
require_once(__DIR__.'/search/difficulty_condition.php');
require_once(__DIR__.'/search/subject_condition.php');
require_once(__DIR__.'/search/topic_condition.php');
require_once(__DIR__.'/search/subtopic_condition.php');
class test_creator_bank_view extends \mod_quiz\question\bank\custom_view{

    protected function wanted_columns() {
        global $CFG;

        if (empty($CFG->quizquestionbankcolumns)) {
            $quizquestionbankcolumns = array(
                'checkbox_column',
                'question_type_column',
                'question_name_text_column',
                'preview_action_column',
            );
        } else {
            $quizquestionbankcolumns = explode(',', $CFG->quizquestionbankcolumns);
        }

        foreach ($quizquestionbankcolumns as $fullname) {
            if (!class_exists($fullname)) {
                if (class_exists('mod_quiz\\question\\bank\\' . $fullname)) {
                    $fullname = 'mod_quiz\\question\\bank\\' . $fullname;
                } else if (class_exists('core_question\\bank\\' . $fullname)) {
                    $fullname = 'core_question\\bank\\' . $fullname;
                } else if (class_exists('question_bank_' . $fullname)) {
                    debugging('Legacy question bank column class question_bank_' .
                            $fullname . ' should be renamed to mod_quiz\\question\\bank\\' .
                            $fullname, DEBUG_DEVELOPER);
                    $fullname = 'question_bank_' . $fullname;
                } else {
                    throw new coding_exception("No such class exists: $fullname");
                }
            }
            $this->requiredcolumns[$fullname] = new $fullname($this);
        }
        return $this->requiredcolumns;
    }

    public function display($tabname, $page, $perpage, $cat,
            $recurse, $showhidden, $showquestiontext, $tagids = [], $subjectids = [], $topicids = [],
            $subtopicids = []) {
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
        array_unshift($this->searchconditions, new \core_question\bank\search\subtopic_condition($subtopicids));
        array_unshift($this->searchconditions, new \core_question\bank\search\topic_condition($topicids));
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
            $showtextoption = true, $show_shared = false) {
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
        if ($this->baseurl->param('qtopicids[0]')) {
            $index = 0;
            while ($this->baseurl->param("qtopicids[{$index}]")) {
                $excludes[] = "qtopicids[{$index}]";
                $index++;
            }
        }
        if ($this->baseurl->param('qsubtopicids[0]')) {
            $index = 0;
            while ($this->baseurl->param("qsubtopicids[{$index}]")) {
                $excludes[] = "qsubtopicids[{$index}]";
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
        $this->display_show_shared_checkbox($show_shared);
        $this->display_advanced_search_form();
        $go = \html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('go')));
        echo \html_writer::tag('noscript', \html_writer::div($go), array('class' => 'inline'));
        echo \html_writer::end_div();
        echo \html_writer::end_tag('form');
        $PAGE->requires->yui_module('moodle-question-searchform', 'M.question.searchform.init');
    }

    public function display_show_shared_checkbox($show_shared) {
        echo '<div>';
        echo \html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'qbshowshared',
                                               'value' => 0, 'id' => 'qbshowshared_off'));
        echo \html_writer::checkbox('qbshowshared', '1', $show_shared, '&nbsp; Show shared queestions',
                                       array('id' => 'qbshowshared_on', 'class' => 'searchoptions'));
        echo "</div>\n";
    }

}
