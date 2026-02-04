<?php
//connnection
$connection = new mysqli('localhost', 'root', '', 'todo_app');
if ($connection->connect_error) {
    die('Connection Failed' . $connection->connect_error);
}

?>