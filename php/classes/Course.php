<?php
class Course extends Entity {
    public $courseCode, $crn, $room, $start, $finish;

    public function __construct($id, $courseCode, $crn, $room, $start, $finish) {
        parent::__construct($id);
        $this->courseCode = $courseCode;
        $this->crn = $crn;
        $this->room = $room;
        $this->start = $start;
        $this->finish = $finish;
    }

    public function startToString() {
        return time24_to_string($this->start);
    }

    public function finishToString() {
        return time24_to_string($this->finish);
    }
}
