<?php
session_start(); // Ensure session is started

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Print the received data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Retrieve form data
    $id = $_POST['id'];
    $student_name = $_POST['student_name'];
    $timein = $_POST['timein'];
    $timeout = $_POST['timeout'];
    $student_id = $_POST['student_id'];

    // Debugging: Check the timeout value
    if (empty($timeout)) {
        die("Error: Time Out is empty.");
    }

    // Update the SQL query
    $sql = "UPDATE attendance
            SET student_name = ?, timein = ?, timeout = ?, student_id = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters (4 strings and 1 integer)
        $stmt->bind_param('ssssi', $student_name, $timein, $timeout, $student_id, $id);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['status'] = 'updated'; // Set session status
            echo "<script>alert('Record updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }
}
?>