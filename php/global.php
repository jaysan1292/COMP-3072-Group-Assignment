<?php
require_once 'functions.php';
require_once 'config.inc';

function __autoload($class_name) {
    if(file_exists(__DIR__ . '/classes/' . $class_name . '.php')) {
        require_once "classes/$class_name.php";
    } else {
        throw new Exception("Unable to load $class_name.");
    }
}

date_default_timezone_set('America/Toronto');
