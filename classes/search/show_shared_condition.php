<?php
/**
 * A search class to control whether hidden / deleted questions are hidden in the list.
 *
 * @package   core_question
 * @copyright 2013 Ray Morris
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_question\bank\search;
defined('MOODLE_INTERNAL') || die();

/**
 * This class controls whether hidden / deleted questions are hidden in the list.
 *
 * @copyright 2013 Ray Morris
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class show_shared_condition extends condition {
    /** @var bool Whether to include old "deleted" questions. */
    protected $hide;

    /** @var string SQL fragment to add to the where clause. */
    protected $where;

    /**
     * Constructor.
     * @param bool $hide whether to include old "deleted" questions.
     */
    public function __construct($hide = true) {
        $this->hide = $hide;
        if ($hide) {
            $this->where = 'q.id IN (SELECT ti.questionid
                                       FROM {question_filters} ti
                                      WHERE ti.shared = 1)';
        } else {
            $this->where = 'q.id IN (SELECT ti.questionid
                                       FROM {question_filters} ti
                                      WHERE ti.shared = 0)';
        }
    }

    public function where() {
        return  $this->where;
    }

    // /**
    //  * Print HTML to display the "Also show old questions" checkbox
    //  */
    // public function display_options_adv() {
    //     echo \html_writer::start_div();
    //     echo \html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'showhidden',
    //                                                'value' => '0', 'id' => 'showhidden_off'));
    //     echo \html_writer::checkbox('showhidden', '1', (! $this->hide), get_string('showhidden', 'question'),
    //                                array('id' => 'showhidden_on', 'class' => 'searchoptions'));
    //     echo \html_writer::end_div() . "\n";
    // }
}
