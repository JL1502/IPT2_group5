<?php
    // Database configuration
    $DB_SERVER = "localhost";
    $DB_NAME = "attendance_management_system";
    $DB_USERNAME = "root";
    $DB_PASSWORD = '';

    // Create connection
    $conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        // Log the error (for production)
        error_log("Database connection failed: " . $conn->connect_error);
        // Display a generic error message
        die("Unable to connect to the database. Please try again later.");
    } else {
        echo "Database Connection Successful.";
    }

    // Close the connection when done
    // $conn->close();
?>