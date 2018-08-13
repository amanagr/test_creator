<?php

namespace core_question\bank\search;
defined('MOODLE_INTERNAL') || die();

class difficulty_condition extends condition {
    protected $where;
    protected $params;

    public function __construct($selecteddifficulty = "all") {
        global $DB;

    }

    public function where() {
        return $this->where;
    }

    public function params() {
        return $this->params;
    }

    public function display_options() {
        global $OUTPUT;

        echo 'hola';
    }
}
