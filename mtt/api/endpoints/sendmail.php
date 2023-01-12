<?php
require_once '../../classes/Mtt.php';
$mtt = new Mtt();

$validRequest = false;
if(array_key_exists('filename', $_POST)){
    $filename = $_POST['filename'];
    $validRequest = true;
} elseif(array_key_exists('filename', $_GET)){
    $filename = $_GET['filename'];
    $validRequest = true;
}

if($validRequest){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array(
        'status' => false,
        'error' => 'errortext'
    ));

}