<?php

include("../../model/dbFunctions.php");

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$result = getAllHighscores();
echo json_encode($result, JSON_UNESCAPED_UNICODE);
