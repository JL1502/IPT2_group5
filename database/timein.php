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

    // Record Time In
    $time_in = date('Y-m-d H:i:s'); // Current timestamp

    $stmt = $conn->prepare("INSERT INTO attendance (student_id, time_in) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $time_in);

    if ($stmt->execute()) {
        echo "Time In recorded successfully for Student ID: $student_id at $time_in.<br>";
    } else {
        echo "Error recording Time In: " . $stmt->error . "<br>";
    }

    $stmt->close();
    $conn->close();
?>