<?php
namespace block_test_creator;

defined('MOODLE_INTERNAL') || die();
require_once $CFG->libdir . "/externallib.php";
use external_api;
use external_function_parameters;
use external_value;
use context_user;


class block_test_creator_external extends external_api
{
    public static function filter_topics_parameters()
    {
        return new external_function_parameters([
            'subject_id' => new external_value(
                PARAM_INT, 'Item text describing what is to be done'),
            'type' => new external_value(
                PARAM_ALPHA, 'topic/subtopic')
        ]);
    }

    public static function filter_topics($subject_id, $type)
    {
        global $DB, $USER, $PAGE;

        $context = context_user::instance($USER->id);
        self::validate_context($context);

        $params = self::validate_parameters(
            self::filter_topics_parameters(), compact('subject_id', 'type'));

        $data = array(); 
        if($params['type'] =='topic')
        {
            $records = $DB->get_records('topic', array('subjectid' => $params['subject_id']));
            return $records; 
        }
        elseif ($params['type']=='subtopic')
        {
            return $DB->get_records('subtopic', array('topicid' => $params['subject_id']));
        }
        return $data;
    }
    public static function filter_topics_returns()
    {
        return null;
    }
}
