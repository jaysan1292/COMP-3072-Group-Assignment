<?php
abstract class Entity {
    public $id;

    public function __construct($id) {
        $this->id = $id;
    }
}
