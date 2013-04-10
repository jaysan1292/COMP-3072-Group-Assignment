<?php
class User extends Entity {
    public $firstName,  // string
           $lastName,   // string
           $email,      // string
           $department, // string
           $isAdmin;    // boolean

    /**
     * Creates a new User instance given the proper values.
     * Usage:
     * User::create($id, $firstName, $lastName, $email, $department, $isAdmin);
     *
     * Property     Type      Required?   Default Value
     * id           integer   yes         default: -1
     * firstName    string    yes         default: ''
     * lastName     string    yes         default: ''
     * email        string    no          default: ''
     * department   string    no          default: ''
     * isAdmin      boolean   no          default: false
     */
    static function create() {
        $numargs = func_num_args();
        if($numargs < 3 || $numargs > 6) return false;
        $args = func_get_args();

        $u = new User;

        // required values
        $u->id        = (integer) $args[0];
        $u->firstName = (string)  $args[1];
        $u->lastname  = (string)  $args[2];

        // not required values
        $u->email      = isset($args[3]) ? $args[3] : '';
        $u->department = isset($args[4]) ? $args[4] : '';
        $u->isAdmin    = isset($args[5]) ? $args[5] : false;

        return $u;
    }

    static function fromUser(User $user) {
        return User::create($user->id, $user->firstName, $user->lastName, $user->email, $user->department, $user->isAdmin);
    }

    public function __toString() {
        return "$this->firstName $this->lastName";
    }
}
