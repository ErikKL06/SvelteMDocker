<?php

include("../../model/dbFunctions.php");

$result = getAllHighscores();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
echo json_encode($result, JSON_UNESCAPED_UNICODE);
