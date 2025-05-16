<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$result = ['success' => false]; // Initialize result with default value
$jsonData = json_decode(file_get_contents('php://input'), true);

if (isset($jsonData['email'], $jsonData['username'], $jsonData['password'])) {
    include('../../model/dbFunctions.php');
    // Use $jsonData instead of filter_input
    $email = htmlspecialchars($jsonData['email']);
    $user = htmlspecialchars($jsonData['username']);
    $pwd = password_hash($jsonData['password'], PASSWORD_DEFAULT);
    $result['success'] = addUser($email, $user, $pwd);
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
