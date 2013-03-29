<?php
require_once 'php/global.php';

$user = $_POST['username'];
$pass = $_POST['password'];

// TODO: Set cookie to remember user login info
@$remember = (boolean) $_POST['remember'];

$auth = new Authenticator();
$success = $auth->authenticateUser($user, $pass, $login);

if($success) {
    session_start();
    $_SESSION['current_user'] = $login;
    $_SESSION['logged_in'] = TRUE;

    if($login->isAdmin) {
        redirect_to_page(ADMIN_PAGE);
    } else {
        redirect_to_page(HOME_PAGE);
    }
} else {
    // TODO: I really don't like the fact that the message is sent in the query string... it's a little thing, but it's too easy for the user to modify :p

    // Redirect to login screen, with an error message
    $errmsg = urlencode('Incorrect username or password.');
    redirect_to_page(LOGIN_PAGE . "?msg=$errmsg");
}
