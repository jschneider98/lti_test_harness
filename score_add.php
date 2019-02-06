<?php

$body = file_get_contents('php://input');

if ($body) {
    $handle = fopen("scores.txt", "a");
    fwrite($handle, "******************************\n");
    fwrite($handle, $body);
    fclose($handle);
}

echo "ok";
