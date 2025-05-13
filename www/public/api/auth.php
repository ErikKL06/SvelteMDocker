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



if (isset($_POST['password'], $_POST['user'])) {
    $user = filter_input(INPUT_POST, 'user', FILTER_UNSAFE_RAW);
    //$pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $pwd = $_POST['password'];
    $user = auth($user, $pwd);


    /** Kontroll att resultat finns */
    if ($user['success']) {

        $_SESSION['uid'] = $user['uid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
    }
}

header('Content-Type: application/json');
echo json_encode($user, JSON_UNESCAPED_UNICODE);
