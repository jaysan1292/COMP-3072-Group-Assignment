<?php

require_once 'php/functions.php';

session_start();

if(isset($_SESSION['current_user']))
    unset($_SESSION['current_user']);

if(isset($_SESSION['logged_in']))
    unset($_SESSION['logged_in']);

redirect_to_page(LOGIN_PAGE);
