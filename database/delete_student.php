<?php
include('database/database.php');

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM attendance WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting student: " . mysqli_error($conn);
    }
} else {
    echo "Invalid student ID.";
}
?>