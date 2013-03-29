<?php

require_once 'php/functions.php';

session_start();

$_SESSION = array();

if(ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
              $params["path"], $params["domain"],
              $params["secure"], $params["httponly"]);
}

session_destroy();

redirect_to_page(LOGIN_PAGE);
