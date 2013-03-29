<?php
class User extends Entity {
    public $firstName;
    public $lastName;
    public $isAdmin;

    public function __construct($id, $firstName, $lastName, $isAdmin) {
        parent::__construct($id);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->isAdmin = $isAdmin;
    }

    static function fromUser(User $user) {
        return new User($user->id, $user->firstName, $user->lastName, $user->isAdmin);
    }

    public function __toString() {
        return "$this->firstName $this->lastName";
    }
}
