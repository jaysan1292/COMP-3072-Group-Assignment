<?php
class LoginUser extends User {
    public $loginName;
    public $password;

    public function __construct($id, $firstName, $lastName, $loginName, $password) {
        parent::__construct($id, $firstName, $lastName);
        $this->loginName = $loginName;
        $this->password = $password;
    }

    function toUser() {
        return new User($this->id, $this->firstName, $this->lastName);
    }
}
