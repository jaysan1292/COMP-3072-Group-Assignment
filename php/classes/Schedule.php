<?php
class Schedule extends Entity {
    public $user;      // User
    public $courses;   // Array of Courses

    public function __construct($id, User $user, $courses = array()) {
        parent::__construct($id);
        $this->user = $user;
        $this->courses = $courses;
    }
}
