<?php
class Course extends Entity {
    public $courseCode, $crn, $desc, $room, $type, $day, $start, $finish;

    public function __construct($id, $courseCode, $crn, $desc, $room, $type, $day, $start, $finish) {
        $this->id = $id;
        $this->courseCode = $courseCode;
        $this->crn = $crn;
        $this->desc = $desc;
        $this->room = $room;
        $this->type = $type;
        $this->day = $day;
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
