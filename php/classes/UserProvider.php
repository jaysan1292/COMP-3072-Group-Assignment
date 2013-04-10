<?php
class UserProvider extends DbProvider {
    private $query = 'CALL GetUser(?)';
    protected function buildObject($results) {
        $id = $results['u_id'];
        $fn = $results['first_name'];
        $ln = $results['last_name'];
        $em = $results['email'];
        $de = $results['dept_name'];

        switch($results['u_type']) {
            case 1:  $admin = false; break;
            case 2:  $admin = true;  break;
            default: $admin = false; break;
        }

        if($id && $fn && $ln && $em && $de) {
            $out = User::create($id, $fn, $ln, $em, $de, $admin);
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
        if($cmd = $db->prepare('SELECT * from User ORDER BY u_id ASC')) {
            $cmd->execute();
            while($result = $cmd->fetch()) {
                $users[] = $this->buildObject($result);
            }
        }
        $db->commit();

        return $users;
    }
}
