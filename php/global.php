<?php
require_once 'functions.php';

function __autoload($class_name) {
    if(file_exists(__DIR__ . '/classes/' . $class_name . '.php')) {
        require_once "classes/$class_name.php";
    } else {
        throw new Exception("Unable to load $class_name.");
    }
}

/* * * * * * * * * * * * *
 * Configuration section *
 * * * * * * * * * * * * */

// The root directory of the site
define('ROOT_DIR', '/3072');

// Where to redirect users upon successful login
define('HOME_PAGE', '/test.php');

// Login page
define('LOGIN_PAGE', '/index.php');
