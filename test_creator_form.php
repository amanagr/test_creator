<?php

require_once("{$CFG->libdir}/formslib.php");
 
class test_creator_form extends moodleform {
 
    function definition() {
 
        $mform =& $this->_form;
        $mform->addElement('header','displayinfo', 'Create cutom test.');
    }
}
