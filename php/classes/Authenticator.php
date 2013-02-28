<?php
class Authenticator {
    function authenticateUser($username, $password, &$user) {
        $l = new LoginProvider();
        $login = $l->getLogin($username);

        if($login == null) {
            $user = null;
            return false;
        }

        $user = User::fromUser($login);
        return PasswordHelper::checkPassword($password, $login->password);
    }
}
