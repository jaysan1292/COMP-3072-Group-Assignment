<?php
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

function professor_init_departments() {
    admin_init_departments();
}

function professor_init_timeoff_requests() {
    global $p_requests;
    if(isset($p_requests)) return;

    $db = DbProvider::openConnection();
    $db->beginTransaction();

    $cmd = $db->prepare('CALL GetUserTimeOffRequests(?)');
    $cmd->bindParam(1, $_SESSION['current_user']->id);

    if($cmd->execute()) {
        while(($result = $cmd->fetch())) {
            $p_requests[] = array(
                'TimeOffId'     => $result['Id'],
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

function professor_has_courses() {
    professor_init_courses();
    global $professor_courses;
    return (count($professor_courses) > 0);
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

function professor_has_open_requests() {
    return count(professor_get_open_requests()) > 0;
}

function professor_has_closed_requests() {
    return count(professor_get_closed_requests()) > 0;
}

function professor_get_open_requests() {
    unset($GLOBALS['p_requests']);
    professor_init_timeoff_requests();
    global $p_requests;

    if(is_null($p_requests)) return array();
    return array_filter($p_requests, function($req) {
        return timeoff_status_open($req);
    });
}

function professor_get_closed_requests() {
    unset($GLOBALS['p_requests']);
    professor_init_timeoff_requests();
    global $p_requests;

    if(is_null($p_requests)) return array();
    return array_filter($p_requests, function($req) {
        return timeoff_status_closed($req);
    });
}
