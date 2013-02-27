<?php
require_once('classes.php');

function open_connection() {
    $db = new PDO('mysql:host=home.jaysan1292.com;dbname=bohhls',
                  'bohhls',
                  'parallelline');
    return $db;
}

/***********************
 * Database accessors
 */
abstract class DbProvider {
    abstract protected function buildObject($results);
    abstract protected function doQuery(PDO $db, $id);
    
    public function get($id) {
        $db = open_connection();
        $db->beginTransaction();
        
        $obj = $this->doQuery($db, $id);
        
        $db->commit();
        return $obj;
    }
}

class UserProvider extends DbProvider {
    private $query = 'CALL GetUser(?)';
    protected function buildObject($results) {
        $id = $results['u_id'];
        $fn = $results['first_name'];
        $ln = $results['last_name'];
        if($id && $fn && $ln)
            return new User($id, $fn, $ln);
    }
    
    protected function doQuery(PDO $db, $id) {
        $cmd = $db->prepare($this->query);
        $cmd->bindParam(1, $id);
        if($cmd->execute()) {
            $user = $this->buildObject($cmd->fetch());
        }
        
        if(!is_null($user)) {
            return $user;
        }
    }
}

class LoginProvider extends UserProvider {
    private $query = 'CALL GetLoginUserWithId(?)';
    
    protected function buildObject($results) {
        $user = parent::buildObject($results);
        if(is_null($user)) return null;
        
        $login = LoginUser::fromUser($user);
        $login->loginName = $results['login_name'];
        $login->password = $results['login_password'];
        
        return $login;
    }
    
    protected function doQuery(PDO $db, $id) {
        $cmd = $db->prepare($this->query);
        $cmd->bindParam(1, $id);
        if($cmd->execute()) {
            $user = $this->buildObject($cmd->fetch());
        }
        
        if(!is_null($user)) {
            return $user;
        }
    }
}

require_once('functions.php');

$u = new LoginProvider();
$user = $u->get(1);
code_dump($user);