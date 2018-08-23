<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings form for overrides in the quiz module.
 *
 * @package    mod_quiz
 * @copyright  2010 Matt Petro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/mod/quiz/mod_form.php');
require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');


/**
 * Form for editing settings overrides.
 *
 * @copyright  2010 Matt Petro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class test_creator_mod_form extends moodleform {

public static $datefieldoptions = array('optional' => false);

    protected $_feedbacks;
    protected static $reviewfields = array(); // Initialised in the constructor.

    /** @var int the max number of attempts allowed in any user or group override on this quiz. */
    protected $maxattemptsanyoverride = null;


    public function definition() {
        global $COURSE, $CFG, $DB, $PAGE;
        $quizconfig = get_config('quiz');
        $mform = $this->_form;

        // -------------------------------------------------------------------------------
        //$mform->addElement('header', 'general', get_string('general', 'form'));

        // Open and close dates.
        $mform->addElement('date_time_selector', 'timeopen', get_string('quizopen', 'quiz'),
                self::$datefieldoptions);
        $mform->addHelpButton('timeopen', 'quizopenclose', 'quiz');

        $mform->addElement('date_time_selector', 'timeclose', get_string('quizclose', 'quiz'),
                self::$datefieldoptions);

        // Time limit.
        $mform->addElement('duration', 'timelimit', get_string('timelimit', 'quiz'),
                array('optional' => false));
        $mform->addHelpButton('timelimit', 'timelimit', 'quiz');
        $mform->setAdvanced('timelimit', $quizconfig->timelimit_adv);
        $mform->setDefault('timelimit', $quizconfig->timelimit);


        // Shuffle within questions.
        $mform->addElement('selectyesno', 'shuffleanswers', get_string('shufflewithin', 'quiz'));
        $mform->addHelpButton('shuffleanswers', 'shufflewithin', 'quiz');
        $mform->setAdvanced('shuffleanswers', $quizconfig->shuffleanswers_adv);
        $mform->setDefault('shuffleanswers', $quizconfig->shuffleanswers);

        // Number of attempts.
        $attemptoptions = array('0' => get_string('unlimited'));
        for ($i = 1; $i <= QUIZ_MAX_ATTEMPT_OPTION; $i++) {
            $attemptoptions[$i] = $i;
        }
        $mform->addElement('select', 'attempts', get_string('attemptsallowed', 'quiz'),
                $attemptoptions);
        $mform->setAdvanced('attempts', $quizconfig->attempts_adv);
        $mform->setDefault('attempts', $quizconfig->attempts);

        $this->add_action_buttons();
}
}
