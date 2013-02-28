<?php
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
