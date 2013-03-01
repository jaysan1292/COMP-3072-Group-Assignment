<?php
class CourseDbProvider {
    private $query = 'CALL GetCourseInfo(?, ?)';

    protected function buildObject($results) {
        $id = $results['c_id'];
        $code = $results['c_code'];
        $crn = $results['c_crn'];
        $rnum = $results['rm_number'];
        $start = $results['start_time'];
        $finish = $results['finish_time'];

        if($id && $code && $crn && $rnum && $start && $finish)
            return new Course($id, $code, $crn, $rnum, $start, $finish);
    }

    public function get($id, $type) {
        $db = DbProvider::openConnection();
        $db->beginTransaction();

        $course = $this->doQuery($db, $id, $type);

        $db->commit();
        return $course;
    }

    protected function doQuery(PDO $db, $id, $type) {
        $cmd = $db->prepare($this->query);
        $cmd->bindParam(1, $id);
        $cmd->bindParam(2, $type);
        if($cmd->execute()) {
            $results = $cmd->fetch();
            $course = $this->buildObject($results);
        }

        return $course;
    }
}
