<?php

define('__ROOT__', dirname(__FILE__));

var_dump($_POST['text_input']);

switch ($_FILES['file_input']['error']) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_NO_FILE:
        echo "No file sent" . PHP_EOL;
        exit();
    case UPLOAD_ERR_INI_SIZE:
        echo "failed to init file" . PHP_EOL;
        exit();
    case UPLOAD_ERR_FORM_SIZE:
        echo "File exceeds maximum filesize limit" . PHP_EOL;
        exit();
    default:
        echo "Something went wrong... I wish you knew what" . PHP_EOL;
        exit();
}

$targetDir = "/img/";
$targetFile = __ROOT__ . $targetDir . basename($_FILES['file_input']['name']);

if (file_exists($targetFile)) {
    echo "This file already exists on the server" . PHP_EOL;
    exit();
}

$sourceFile = $_FILES['file_input']['tmp_name'];

var_dump($sourceFile, $targetFile);

if(move_uploaded_file($sourceFile, $targetFile) === false) {
    echo "The file could not be uplaoded!" . PHP_EOL;
    exit();
}

echo "File uploaded successfully!" . PHP_EOL;
