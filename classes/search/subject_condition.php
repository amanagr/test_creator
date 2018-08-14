<?php

namespace core_question\bank\search;
defined('MOODLE_INTERNAL') || die();

class subject_condition extends condition {
    protected $where;
    protected $params;
    protected $subject;

    public function __construct($selectedsubject = "All") {
        global $DB;
        $this->subject = $selectedsubject;
    }

    public function where() {
        return $this->where;
    }

    public function params() {
        return $this->params;
    }

    public function display_options() {
        global $OUTPUT;

        
        $subjectoptions = array(
            array(
                "id" => 0,
                "name" => "All",
                "selected" => true
            ),
            array(
                "id" => 1,
                "name" => "Easy",
                "selected" => false
            ),
            array(
                "id" => 2,
                "name" => "Medium",
                "selected" => false
            ),
            array(
                "id" => 3,
                "name" => "Hard",
                "selected" => false
            ),
            array(
                "id"=> 4,
                "name"=> "Advance",
                "selected"=> false
            )
        );
        
         $jdata['subjectoptions'] = $subjectoptions;
        echo $OUTPUT->render_from_template('block_test_creator/subject_condition', 
            $jdata);
    }
}
