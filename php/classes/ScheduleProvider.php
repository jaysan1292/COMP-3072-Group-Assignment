<?php
class ScheduleProvider extends DbProvider {
    private $query = 'CALL GetProfessorSchedule(?)';

    protected function buildObject($results) {

    }

    protected function doQuery(PDO $db, $id) {
        $cmd = $db->prepare($this->query);
        $cmd->bindParam(1, $id);

        if($cmd->execute()) {
            $results = $cmd->fetch();
            if($results) {
                $s_id = $results['s_id'];
                $fn = $results['first_name'];
                $ln = $results['last_name'];
                $user = User::create($id, $fn, $ln);

                do {
                    $c_id = $results['c_id'];
                    $code = $results['c_code'];
                    $crn = $results['c_crn'];
                    $desc = $results['c_description'];
                    $room = $results['rm_number'];
                    $type = $results['type_desc'];
                    $day = db_day_to_string($results['day']);
                    $start = $results['start_time'];
                    $finish = $results['finish_time'];
                    $courses[] = new Course($c_id, $code, $crn, $desc, $room, $type, $day, $start, $finish);
                } while($results = $cmd->fetch());
            }
        }

        if(isset($s_id) && isset($user) && isset($courses)) {
            $schedule = new Schedule($s_id, $user, $courses);
        }

        if(isset($schedule) && !is_null($schedule)) {
            return $schedule;
        }
    }
}
