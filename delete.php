<?php
include('connection.php');

$sql = "DELETE FROM list WHERE id = ?";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    header("Location: index.php");
}
?>