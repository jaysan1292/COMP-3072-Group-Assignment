<?php

/***********************
 * Main Data Classes
 */
abstract class Entity {
    public $id;

    public function __construct($id) {
        $this->id = $id;
    }
}

class User extends Entity {
    public $firstName;
    public $lastName;

    public function __construct($id, $firstName, $lastName) {
        parent::__construct($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    static function fromUser(User $user) {
        return new User($user->id, $user->firstName, $user->lastName);
    }

    public function __toString() {
        return "$this->firstName $this->lastName";
    }
}

class LoginUser extends User {
    public $loginName;
    public $password;

    public function __construct($id, $firstName, $lastName, $loginName, $password) {
        parent::__construct($id, $firstName, $lastName);
        $this->loginName = $loginName;
        $this->password = $password;
    }

    function toUser() {
        return new User($this->firstName, $this->lastName);
    }
}

class Course extends Entity {

}

class Schedule extends Entity {
    public $user; // User
    public $courses; // Array
}

/***********************
 * Supplementary classes
 */
class Point {
    public $x, $y;

    function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }
}

class Rectangle {
    public $x, $y, $width, $height;

    function __construct($x, $y, $width, $height) {
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }
}

class Line {
    public $p1, $p2;

    function __construct($a, $b) {
        $this->p1 = $a;
        $this->p2 = $b;
    }

    function midpoint() {
        $x = ($this->p1->x + $this->p2->x) / 2;
        $y = ($this->p1->y + $this->p2->y) / 2;

        return new Point($x, $y);
    }
}
