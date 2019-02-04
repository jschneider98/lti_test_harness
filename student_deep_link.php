<?php

session_save_path('./');
session_start();

require_once('display.php');
require_once('student_deep_link_template.php');
require_once('Loader.php');


$data = json_decode($_SESSION['deep_link_data'], true);
// var_dump($data);

$params = getParams($data);

//var_dump($params);

$template = new StudentDeepLinkTemplate($params);
$display = new Display();
$display->add($template->toHtml());

echo $display->toHtml();

/**
 *
 */
function getParams($data = [])
{
    if (!$data) {
        return [];
    }

    $opts = [
        'teacher_context' => false,
    ];

    $params = Loader::loadFormParams($opts);
    $client = Loader::loadClient($params);

    $url = $data['url'];

    $form_params = [
        'lti_message_type'                 => $params['lti_message_type'],
        'lti_version'                      => $params['lti_version'],
        'lis_person_contact_email_primary' => $params['lis_person_contact_email_primary'],
        'lis_outcome_service_url'          => 'http://localhost:8081/todo.php',
        'lis_result_sourcedid'             => 'todo',
        'custom_debug'                     => $params['custom_debug'],
        'submit_go'                        => 'Go',
    ];

    $params = [
        'title'       => $data['title'],
        'url'         => $url,
        'client'      => $client,
        'form_params' => $form_params,
    ];

    return $params;
}
