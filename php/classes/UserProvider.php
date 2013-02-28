<?php
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
