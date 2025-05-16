<?php

/**
 * Autentiserar användare.
 * Om inget postat så kontrolleras om sessionsvariabeln lever (=)
 * 
 * @param $_POST['username']  användarnamn vid inloggning
 * @param $_POST['pwd']       lösenord 
 * @return {"auth": true/false, "userdata": {uid, firstname, surname}/null} 
 */
session_start();

include('../../model/dbFunctions.php');
$jsonData = json_decode(file_get_contents('php://input'), true);

if (isset($_SESSION['uid'])) {
    $user = [
        'success' => true,
        'uid' => $_SESSION['uid'],
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email']
    ];
} elseif (isset($jsonData['password'], $jsonData['username'])) {
    $user = filter_var($jsonData['username'], FILTER_UNSAFE_RAW);
    $pwd = $jsonData['password'];
    $user = auth($user, $pwd);

    /** Kontroll att resultat finns */
    if ($user['success']) {

        $_SESSION['uid'] = $user['uid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
    }
} else {
    $user = [
        'success' => false,
        'uid' => null,
        'username' => null,
        'email' => null
    ];
}


header('Content-Type: application/json');
echo json_encode($user, JSON_UNESCAPED_UNICODE);
