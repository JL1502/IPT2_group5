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

    // Insert Data (Create)
    $name = "John Doe";
    $email = "john.doe@example.com";
    $attendance_status = "present";

    $stmt = $conn->prepare("INSERT INTO students (name, email, attendance_status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $attendance_status);

    if ($stmt->execute()) {
        echo "New student record created successfully.<br>";
    } else {
        echo "Error inserting record: " . $stmt->error . "<br>";
    }

    $stmt->close();
    $conn->close();
?>