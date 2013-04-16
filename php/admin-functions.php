<?php
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

function admin_has_requests() {
    admin_init_timeoff_requests();
    global $requests;
    return (count($requests) > 0);
}

function admin_has_open_requests() {
    admin_init_timeoff_requests();
    global $requests;
    foreach($requests as $request) {
        if($request['StatusId'] == 1) return true;
    }
    return false;
}

function admin_get_open_requests() {
    unset($GLOBALS['requests']);
    admin_init_timeoff_requests();
    global $requests;

    return array_filter($requests, function($req) {
        return timeoff_status_open($req);
    });
}

function admin_get_closed_requests() {
    unset($GLOBALS['requests']);
    admin_init_timeoff_requests();
    global $requests;

    return array_filter($requests, function($req) {
        return timeoff_status_closed($req);
    });
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
