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

        if($id && $fn && $ln) {
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

    public function getAllUsers() {
        $db = DbProvider::openConnection();
        $db->beginTransaction();
        if($cmd = $db->prepare('SELECT u_id from User ORDER BY u_id ASC')) {
            $cmd->execute();
            while($result = $cmd->fetch()) {
                $u_id = $result['u_id'];
                $users[] = $this->doQuery($db, $u_id);
            }
        }
        $db->commit();

        return $users;
    }
}
