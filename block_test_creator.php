<?php

class block_test_creator extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_test_creator');
    }
    public function get_content() {
    	$this->content = new stdClass();
        $output = $this->page->get_renderer('block_test_creator');
        $add_new_test = new \block_test_creator\output\add_new_test();
        $this->content->text = $output->render($add_new_test);
        return $this->content; 
    }
}
