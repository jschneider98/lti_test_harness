<?php

session_save_path('./');
session_start();

require_once('display.php');

$file_name = 'scores.txt';

$display = new Display();

$form = <<< HTML
<form method="POST">
    <input type="submit" name="submit_clear" value="Clear Log"/>
</form>
HTML;

$display->add($form);

if (isset($_POST['submit_clear'])) {
    $handle = fopen($file_name, "w");
    fclose($handle);
    $display->add("Score log cleared.");
}

if (file_exists($file_name) && filesize($file_name) > 0) {
    $handle = fopen($file_name, "r");
    $content = fread($handle, filesize($file_name));

    $content = str_replace(">", ">\n", $content);

    $display->add("<xmp>" . $content . "</xmp>");

    fclose($handle);
}

echo $display->toHtml();
