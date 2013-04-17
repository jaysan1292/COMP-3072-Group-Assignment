<?php

// If you include this file, no need to include global.php
require_once 'global.php';

/*
 * var_export(), but echo'd inside <pre> and <code> tags
 */
function code_dump($var) {
    echo '<pre><code>';
    var_export($var);
    echo '</code></pre>';
}

/*
 * Returns a default value if the given variable is null.
 */
function default_if_null($var, $default = '') {
    return !is_null($var) ? $var : $default;
}

/*
 * Returns the first value from the array whose key matches the
 * given regular expression.
 */
function array_contains_partial_key($array, $pattern) {
    foreach ($array as $key => $value) {
        if(preg_match($pattern, $key)) return $value;
    }
    return false;
}

/*
 * Gets all array key/values that matches the given regular expression.
 */
function array_get_matches($array, $pattern) {
    $output = array();
    foreach ($array as $key => $value) {
        if(preg_match($pattern, $key)) $output[$key] = $value;
    }
    return $output;
}

function timeoff_status_open($request) {
    return $request['StatusId'] == 1;
}

function timeoff_status_closed($request) {
    return !timeoff_status_open($request);
}

function is_get_var_empty($varname) {
    return !isset($_GET[$varname]) || empty($_GET[$varname]);
}

function is_post_var_empty($varname) {
    return !isset($_POST[$varname]) || empty($_POST[$varname]);
}

function is_session_var_empty($varname) {
    return !isset($_SESSION[$varname]) || empty($_SESSION[$varname]);
}

function is_admin_logged_in() {
    if(session_id() == '') session_start();
    if(!is_user_logged_in()) return false;
    return $_SESSION['current_user']->isAdmin;
}

function is_user_logged_in() {
    if(session_id() == '') session_start();
    return !is_session_var_empty('current_user');
}

function func_die($var) {
    if(!headers_sent()) header('Content-Type: text/plain');
    var_export($var);
    die;
}

function get_request_header($header) {
    $h = getallheaders();
    return $h[$header];
}

function send_to_login_page($errmsg = '') {
    // Have a javascript form which will POST to the login page with the given error message.
    ?>
    <form name="_form" method="POST" action="<?=ROOT_DIR?>/index.php">
        <input type="hidden" name="errmsg" value="<?=$errmsg?>"/>
    </form>
    <script type="text/javascript">
        document._form.submit();
    </script>
    <?php
    die;
}

/*
 * Redirects to the specified page. Please note, however,
 * that it will only redirect to pages within the application
 * (i.e., anything under ROOT_DIR). To redirect elsewhere,
 * just set the location header yourself.
 */
function redirect_to_page($page) {
    $vars = get_defined_vars();
    if(!array_key_exists('page', $vars) ||
       is_null($page) ||
       empty($page)) {
        throw new Exception('No page specified', 1);
    }
    // if passed in string does not contain ROOT_DIR
    if(strpos($page, ROOT_DIR) !== FALSE) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $page);
    } else {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . ROOT_DIR . $page);
    }
}

/*
 * Converts a 24-hour time into the equivalent 12-hour format.
 */
function time24_to_string($time) {
    $time = str_replace(':', '', $time);
    $min = substr($time, -2);
    $hour = intval(substr($time, 0, -2));
    $pm = $hour >= 12;

    if($pm && $hour != 12) $hour -= 12;

    return "$hour:$min" . ($pm ? 'PM' : 'AM');
}

/*
 * Converts a day value stored in the database to a day (in words)
 */
function db_day_to_string($day) {
    switch($day) {
        case 1: return 'Monday';
        case 2: return 'Tuesday';
        case 3: return 'Wednesday';
        case 4: return 'Thursday';
        case 5: return 'Friday';
    }
}

function day_string_to_db($day) {
    $day = strtolower($day);
    switch($day) {
        case 'monday':    return 1;
        case 'tuesday':   return 2;
        case 'wednesday': return 3;
        case 'thursday':  return 4;
        case 'friday':    return 5;
    }
}

include 'admin-functions.php';
include 'professor-functions.php';
