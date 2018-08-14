<?php

namespace core_question\bank\search;
defined('MOODLE_INTERNAL') || die();

class difficulty_condition extends condition {
    protected $where;
    protected $params;
    protected $difficulty;

    public function __construct($selecteddifficulty = "All") {
        global $DB;
        $this->difficulty = $selecteddifficulty;
    }

    public function where() {
        return $this->where;
    }

    public function params() {
        return $this->params;
    }

    public function display_options() {
        global $OUTPUT;

        
        $difficultyoptions = array(
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
        
         $jdata['difficultyoptions'] = $difficultyoptions;
        $json = array(array('id'=>1),array('id'=>2));
        $arraydata['data'] = $json;
        echo $OUTPUT->render_from_template('block_test_creator/difficulty_condition', 
            $jdata);
    }
}
