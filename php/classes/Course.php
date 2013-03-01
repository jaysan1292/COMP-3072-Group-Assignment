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
        return $this->timeToString('start');
    }

    public function finishToString() {
        return $this->timeToString('finish');
    }

    private function timeToString($varname) {
        $time = $this->$varname;
        $min = substr($time, -2);
        $hour = intval(substr($time, 0, -2));
        $pm = $hour >= 12;

        if($pm && $hour != 12) $hour -= 12;

        return "$hour:$min" . ($pm ? 'PM' : 'AM');
    }
}
