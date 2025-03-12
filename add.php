<?php
include('database/database.php');

$id = $_GET['id'];
$sql = "SELECT * FROM attendance WHERE id=$id";
$result = mysqli_query($conn, $sql);
$attendance = mysqli_fetch_assoc($result);

echo json_encode($attendance);
?>