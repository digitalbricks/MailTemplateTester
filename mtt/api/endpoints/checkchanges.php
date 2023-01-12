<?php
require_once '../../classes/Mtt.php';
$mtt = new Mtt();


$validRequest = false;
if(array_key_exists('filename', $_POST) && array_key_exists('lastmodified_time', $_POST)){
    $filename = $_POST['filename'];
    $lastmodified_time = $_POST['lastmodified_time'];
    $validRequest = true;
} elseif(array_key_exists('filename', $_GET)  && array_key_exists('lastmodified_time', $_GET)){
    $filename = $_GET['filename'];
    $lastmodified_time = $_GET['lastmodified_time'];
    $validRequest = true;
}
if(!$validRequest){die();}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($mtt->checkFileChanges($filename, $lastmodified_time));

