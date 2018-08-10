<?php
namespace block_test_creator\output;
defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use renderable;
class renderer extends plugin_renderer_base {

    public function render_add_new_test(renderable $add_new_test) {
        return $this->render_from_template('block_test_creator/add_new_test',
            $add_new_test->export_for_template($this));
    }
}
