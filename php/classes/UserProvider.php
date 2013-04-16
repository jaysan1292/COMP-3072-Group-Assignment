<?php
class UserProvider extends DbProvider {
    private $query = 'CALL GetUser(?)';
    protected function buildObject($results) {
        $id = default_if_null($results['u_id'], -1);
        $fn = default_if_null($results['first_name']);
        $ln = default_if_null($results['last_name']);
        $em = default_if_null($results['email']);
        $de = default_if_null($results['dept_name']);
        $co = default_if_null($results['contact']);

        switch($results['u_type']) {
            case 1:  $admin = false; break;
            case 2:  $admin = true;  break;
            default: $admin = false; break;
        }
        if($id && $fn && $ln /*&& $em*/ && $de /*&& $co*/) {
            $out = User::create($id, $fn, $ln, $em, $de, $co, $admin);
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
