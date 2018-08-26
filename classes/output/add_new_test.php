<?php
namespace block_test_creator\output;
defined('MOODLE_INTERNAL') || die();

use moodle_url;
use renderable;
use renderer_base;
use templatable;

class add_new_test implements renderable, templatable {


    public function export_for_template(renderer_base $output) {
        $data = [
            'actionurl' => new moodle_url('/blocks/test_creator/view.php'),
        ];
        return $data;
    }

}
