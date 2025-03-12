<?php
    // Database configuration
    define('DB_SERVER', 'localhost');
    define('DB_NAME', 'attendance_management_system');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    // Create connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        die("Unable to connect to the database. Please try again later.");
    } else {
        echo "Database Connection Successful.<br>";
    }

    // Get student ID (you can pass this via a form or session)
    $student_id = 1; // Replace with the actual student ID

    // Record Time Out
    $time_out = date('Y-m-d H:i:s'); // Current timestamp

    // Update the latest attendance record for the student
    $stmt = $conn->prepare("UPDATE attendance SET time_out = ? WHERE student_id = ? AND time_out IS NULL ORDER BY time_in DESC LIMIT 1");
    $stmt->bind_param("si", $time_out, $student_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Time Out recorded successfully for Student ID: $student_id at $time_out.<br>";
        } else {
            echo "No matching Time In record found for Student ID: $student_id.<br>";
        }
    } else {
        echo "Error recording Time Out: " . $stmt->error . "<br>";
    }

    $stmt->close();
    $conn->close();
?>