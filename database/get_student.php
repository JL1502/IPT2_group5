<?php
include('database/database.php');

$id = $_GET['id'];
$sql = "SELECT * FROM attendance WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    echo json_encode($student);
} else {
    echo json_encode(['error' => 'Student not found']);
}
?>