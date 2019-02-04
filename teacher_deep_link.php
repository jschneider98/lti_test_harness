<?php

session_save_path('./');
session_start();

require_once('display.php');
require_once('Loader.php');

require_once('teacher_deep_link_template.php');

$form_params = Loader::loadFormParams();

$params = [
    'form_params' => $form_params,
];

$template = new TeacherDeepLinkTemplate($params);
$display = new Display();
$display->add($template->toHtml());

echo $display->toHtml();
