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

function admin_init_courses() {
    global $courses;
    if(isset($courses)) return;

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
                    'CourseTypeId'      => $result['CourseTypeId'],
                    'CourseType'        => $result['CourseType'],
                    'RoomNumber'        => $result['RoomNumber'],
                    'RoomType'          => $result['RoomType'],
                    'SectionId'         => $result['SectionId'],
                    'Section'           => $result['Section'],
                    'ProfessorId'       => $result['ProfessorId'],
                    'Professor'         => $result['Professor'],
                );
            }
        }
    }

    $db->commit();
}

function admin_init_professors() {
    global $professors;
    if(isset($professors)) return;

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
                    'DepartmentId'  => $result['DepartmentId'],
                    'Department'    => $result['Department'],
                );
            }
        }
    }

    $db->commit();
}

function admin_init_timeoff_requests() {
    global $requests;
    if(isset($requests)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('CALL GetTimeOffRequests');
    if($cmd->execute()) {
        while(($result = $cmd->fetch())) {
            $requests[] = array(
                'TimeOffId'     => $result['Id'],
                'ProfessorId'   => $result['ProfessorId'],
                'Professor'     => $result['Name'],
                'Date'          => $result['Start'].' to '.$result['End'],
                'Reason'        => $result['Reason'],
                'Status'        => $result['Status'],
                'StatusId'      => $result['StatusId'],
                'DateRequested' => $result['DateRequested'],
            );
        }
    }

    $db->commit();
}

function admin_init_course_sections() {
    global $sections;
    if(isset($sections)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('SELECT * FROM Section');
    if($cmd->execute()) {
        while($result = $cmd->fetch()) {
            $sections[] = array(
                'Id'            => $result['s_id'],
                'Name'          => $result['s_name'],
                'Description'   => $result['s_desc'],
                'Size'          => $result['s_size'],
            );
        }
    }

    $db->commit();
}

function admin_init_timeoff_statuses() {
    global $timeoff_statuses;
    if(isset($timeoff_statuses)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('SELECT * FROM TimeOffStatus');
    if($cmd->execute()) {
        while($row = $cmd->fetch()) {
            $timeoff_statuses[] = array(
                'Id'   => $row['status_id'],
                'Name' => $row['name'],
            );
        }
    }

    $db->commit();
}

function admin_timeoff_status_open($request) {
    return $request['StatusId'] == 1;
}

function admin_init_departments() {
    global $departments;
    if(isset($departments)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('SELECT * FROM Department');
    if($cmd->execute()) {
        while($row = $cmd->fetch()) {
            $departments[] = array(
                'Id'   => $row['dept_id'],
                'Name' => $row['name'],
            );
        }
    }

    $db->commit();
}

function professor_init_courses() {
    $profid = $_SESSION['current_user']->id;

    global $professor_courses;
    if(isset($professor_courses)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('CALL GetProfessorSchedule(?)');
    $cmd->bindParam(1, $profid);

    if($cmd->execute()) {
        while($row = $cmd->fetch()) {
            $professor_courses[] = array(
                'CourseId'          => $row['c_id'],
                'CourseCode'        => $row['c_code'],
                'CRN'               => $row['c_crn'],
                'CourseDescription' => $row['c_description'],
                'CourseType'        => $row['type_desc'],
                'RoomNumber'        => $row['rm_number'],
                'RoomSize'          => $row['rm_size'],
                'Monday'            => $row['monday'],
                'Tuesday'           => $row['tuesday'],
                'Wednesday'         => $row['wednesday'],
                'Thursday'          => $row['thursday'],
                'Friday'            => $row['friday'],
                'StartTime'         => $row['start_time'],
                'FinishTime'        => $row['finish_time'],
            );
        }
    }

    $db->commit();
}

function professor_has_courses() {
    professor_init_courses();
    global $professor_courses;
    return (count($professor_courses) > 0);
}

function professor_init_departments() {
    admin_init_departments();
}

function professor_get_current_department() {
    $profid = $_SESSION['current_user']->id;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('CALL GetUser(?)');
    $cmd->bindParam(1, $profid);

    if($cmd->execute()) {
        $row = $cmd->fetch();
        $department = array(
            'Id'      => $row['dept_id'],
            'Name'    => $row['dept_name'],
        );
    }

    $db->commit();
    return $department;
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
