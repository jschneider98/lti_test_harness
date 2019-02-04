<?php
session_save_path('./');
session_start();

require('display.php');
require('deep_link_return_template.php');

//var_dump($_GET);

$data = json_encode($_GET);

//var_dump($_GET);

$_SESSION['deep_link_data'] = $data;

$params = [
    'data' => $data,
];

$template = new DeepLinkReturnTemplate($params);
$display = new Display();
$display->add($template->toHtml());

echo $display->toHtml();
