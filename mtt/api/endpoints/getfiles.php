<?php
require_once '../classes/Mtt.php';
$mtt = new Mtt;

header('Content-Type: application/json; charset=utf-8');
echo json_encode($mtt->getTemplateFiles());