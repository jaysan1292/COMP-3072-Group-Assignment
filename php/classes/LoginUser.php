<?php
class LoginUser extends User {
    public $loginName;
    public $password;

    public function __construct($id, $firstName, $lastName, $email, $department, $isAdmin, $loginName, $password) {
        parent::__construct($id, $firstName, $lastName, $email, $department, $isAdmin);
        $this->loginName = $loginName;
        $this->password = $password;
    }

    function toUser() {
        return User::create($this->id, $this->firstName, $this->lastName, $this->email, $this->department, $this->isAdmin);
    }
}
