<?php
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

    public function getLogin($username) {
        $db = DbProvider::openConnection();
        $db->beginTransaction();

        $cmd = $db->prepare('CALL GetLoginUser(?)');
        $cmd->bindParam(1, $username);
        if($cmd->execute()) {
            $user = $this->buildObject($cmd->fetch());
        }

        $db->commit();
        return $user;
    }
}
