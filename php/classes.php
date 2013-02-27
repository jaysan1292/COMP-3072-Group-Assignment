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