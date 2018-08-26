<?php

$functions = array(
    'block_test_creator_filter_topics' => array(
        'classname'    => 'block_test_creator\block_test_creator_external',
        'methodname'   => 'filter_topics',
        'classpath'    => 'blocks/test_creator/classes/external/filter_topics.php',
        'description'  => 'Return topics based on subject.',
        'type'         => 'read',
        'ajax'         => true,
        'capabilities' => ''),
);
