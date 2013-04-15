<?php
require_once 'php/global.php';

$user = $_POST['username'];
$pass = $_POST['password'];

// TODO: Set cookie to remember user login info
@$remember = (boolean) $_POST['remember'];

try {
    $auth = new Authenticator;
    $success = $auth->authenticateUser($user, $pass, $login);
} catch(PDOException $e) {
    send_to_login_page('Couldn\'t connect to authentication server. Please try again later.');
}

if($success) {
    session_start();
    session_regenerate_id(true);
    $_SESSION['current_user'] = $login;
    $_SESSION['logged_in'] = TRUE;

    if($login->isAdmin) {
        redirect_to_page(ADMIN_PAGE);
    } else {
        redirect_to_page(HOME_PAGE);
    }
} else {
    // Redirect to login screen, with an error message
    send_to_login_page('Incorrect username or password.');
}
