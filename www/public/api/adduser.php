<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
if (isset($_POST['email'], $_POST['userName'], $_POST['pwd'])) {
    include('../../model/dbFunctions.php');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $user = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $result = addUser($email, $user, $pwd);
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
