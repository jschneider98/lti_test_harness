<?php

session_save_path('./');
session_start();

require_once('display.php');
require_once('Loader.php');

require_once('student_basic_link_template.php');

$params = [
    'form_params' => getParams(),
];

$template = new StudentBasicLinkTemplate($params);
$display = new Display();
$display->add($template->toHtml());

echo $display->toHtml();


/**
 *
 */
function getParams()
{
    $opts = [
        'teacher_context' => false,
    ];

    $params = Loader::loadFormParams($opts);
    $client = Loader::loadClient($params);

    $url = $params['custom_basic_link_url'];

    $form_params = [
        'custom_basic_link_url'            => $params['custom_basic_link_url'],
        'custom_debug'                     => $params['custom_debug'],
        'lti_message_type'                 => $params['lti_message_type'],
        'lti_version'                      => $params['lti_version'],
        'lis_person_contact_email_primary' => $params['lis_person_contact_email_primary'],
        'lis_outcome_service_url'          => $params['lis_outcome_service_url'],
        'lis_result_sourcedid'             => $params['lis_result_sourcedid'],
        'oauth_consumer_key'               => $params['oauth_consumer_key'],
        'oauth_consumer_secret'            => $params['oauth_consumer_secret'],
        'resource_link_id'                 => $params['resource_link_id'],
        'roles'                            => $params['roles'],
        'submit_lti_launch'                => 'LTI Launch',
    ];

    return $form_params;
}