<?php
abstract class DbProvider {
    abstract protected function buildObject($results);
    abstract protected function doQuery(PDO $db, $id);

    public static function openConnection() {
        $db = new PDO('mysql:host=home.jaysan1292.com;dbname=bohhls',
                      'bohhls',
                      'parallelline');
        return $db;
    }

    public function get($id) {
        $db = DbProvider::openConnection();
        $db->beginTransaction();

        $obj = $this->doQuery($db, $id);

        $db->commit();
        return $obj;
    }
}
