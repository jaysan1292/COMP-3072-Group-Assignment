<?php
class UserProvider extends DbProvider {
    private $query = 'CALL GetUser(?)';
    protected function buildObject($results) {
        $id = $results['u_id'];
        $fn = $results['first_name'];
        $ln = $results['last_name'];

        switch($results['u_type']) {
            case 1:  $admin = false; break;
            case 2:  $admin = true;  break;
            default: throw new Exception('Invalid user type: '.$results['u_type'], 1);
        }

        if($id && $fn && $ln && $admin) {
            $out = new User($id, $fn, $ln, $admin);
            return $out;
        }
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
