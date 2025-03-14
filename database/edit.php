<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Print the received data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

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
    $sql = "UPDATE attendace
            SET student_name = ?, timein = ?, timeout = ?, student_id = ?, id = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sssissis', $student_name, $timein,  $timeout, $student_id, $id);
        if ($stmt->execute()) {
            $_SESSION['status'] = 'updated'; 
        } else {
            echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }
}
?>