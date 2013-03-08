<?php
require_once 'php/global.php';

$user = $_POST['username'];
$pass = $_POST['password'];

$auth = new Authenticator();
$success = $auth->authenticateUser($user, $pass, $login);

if($success) {
    session_start();
    $_SESSION['current_user'] = $login;
    // redirect to home page
} else {
    // redirect to login page
}
