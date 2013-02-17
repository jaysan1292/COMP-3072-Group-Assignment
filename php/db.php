<?
function open_connection() {
    $db = new mysqli('localhost','bohhls','parallelline');
    
    return $db;
}

$db = open_connection();