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

function func_die($var) {
    header('Content-Type: text/plain');
    var_export($var);
    die;
}

function admin_init_courses() {
    global $courses;

    // fuck it I'm too tired to make a well-structured data access layer for this
    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('SELECT c_id FROM Course');
    if($cmd->execute()) {
        while(($result = $cmd->fetch())) {
            $ids[] = $result['c_id'];
        }
    }
    unset($cmd);

    foreach ($ids as $id) {
        $cmd = $db->prepare('CALL GetAdminCourseInfo(?)');
        $cmd->bindParam(1, $id);
        if($cmd->execute()) {
            while(($result = $cmd->fetch())) {
                $courses[] = array(
                    'CourseCode'        => $result['CourseCode'],
                    'CourseDescription' => $result['CourseDescription'],
                    'CRN'               => $result['CRN'],
                    'RoomNumber'        => $result['RoomNumber'],
                    'RoomType'          => $result['RoomType'],
                    'Section'           => $result['Section'],
                );
            }
        }
    }

    $db->commit();
}

function admin_init_professors() {
    global $professors;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('SELECT u_id FROM User WHERE u_type = 1');
    if($cmd->execute()) {
        while(($result = $cmd->fetch())) {
            $ids[] = $result['u_id'];
        }
    }
    unset($cmd);

    foreach ($ids as $id) {
        $cmd = $db->prepare('CALL GetAdminProfessorInfo(?)');
        $cmd->bindParam(1, $id);
        if($cmd->execute()) {
            while(($result = $cmd->fetch())) {
                $professors[] = array(
                    'Name'          => $result['Professor'],
                    'ContactNumber' => $result['ContactNumber'],
                    'EmailAddress'  => $result['EmailAddress'],
                    'EmployeeId'    => $result['EmployeeId'],
                    'Department'    => $result['Department'],
                );
            }
        }
    }

    $db->commit();
}
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
