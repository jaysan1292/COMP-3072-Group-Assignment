<?php
require_once("db.php");

class login_provider {
    static function get($user) {
        $db = open_connection();
        $db->beginTransaction();
        
        $result = mysql_query('CALL GetLoginUser()'); // TODD: prepared statements
        
        $db->commit();
    }
}

class authenticator {    
    function authenticate_user($username, $password, &$user) {
        $login = login_provider::get($username);
        
        if($login == null) {
            $user = null;
            return false;
        }
        
        $user = new User($login);
        return password_helper::check_password($password, $login->get_password());
    }
}

class password_helper {
    static function encrypt_password($plaintext) {
        return hash('sha256', $plaintext);
    }
    
    static function check_password($plaintext, $encrypted) {
        echo "Checking $plaintext<br>";
        $hash = password_helper::encrypt_password($plaintext);
        echo $hash . '<br>' . $encrypted . '<br>';
        if($hash == $encrypted) {
            return true;
        }
        return false;
    }
}
