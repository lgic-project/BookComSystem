<?php
define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_DATABASE','users');

function connect( ){
    $conn = new mysqli(DB_DATABASE, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if ($conn->connect_error) {
        return false;
    }
    return $conn;
}
?>