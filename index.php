<?php
include('partials/header.php');
include('partials/sidebar.php');
include('database/database.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_employee'])) {
        // Add Employee
        $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $timein = mysqli_real_escape_string($conn, $_POST['timein']);
        $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);

        $sql = "INSERT INTO attendance (student_name, id, student id, timein, timeout) VALUES ('$student_name', '$id', '$student_id', '$timein' '$timeout')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Student added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding Student: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['edit_attendance'])) {
        // Edit Employee
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $name = mysqli_real_escape_string($conn, $_POST['student_name']);
        $position = mysqli_real_escape_string($conn, $_POST['student_id']);
        $age = mysqli_real_escape_string($conn, $_POST['timein']);
        $address = mysqli_real_escape_string($conn, $_POST['timeout']);

        $sql = "UPDATE attendance SET student_name='$student_name', student_id='$student_id', timein='$timein', timeout='$timeout' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('student updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating student: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['delete_student'])) {
        // Delete Employee
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        $sql = "DELETE FROM students WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('student deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting student: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Fetch employees from the database
$sql = "SELECT * FROM attendance";
$result = mysqli_query($conn, $sql);
$attendance = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>attendance Management System</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">General</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Student Table</h5>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Student</button>
                            </div>
                        </div>

                        <!-- Employee Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">student_id</th>
                                    <th scope="col">student_name</th>
                                    <th scope="col">timein</th>
                                    <th scope="col">timeout</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendance as $student): ?>
                                    <tr>
                                        <th scope="row"><?php echo $student['id']; ?></th>
                                        <td><?php echo $student['student_name']; ?></td>
                                        <td><?php echo $student['student_id']; ?></td>
                                        <td><?php echo $student['timein']; ?></td>
                                        <td><?php echo $student['timeout']; ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal" onclick="editStudent(<?php echo $student['id']; ?>)">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteStudent(<?php echo $student['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Employee Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<!-- Add Employee Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <input type="text" name="student_id" placeholder="Student_id" required>
                    <input type="text" name="student_name" placeholder="Student_name" required>
                    <input type="number" name="timein" placeholder="Timein" required>
                    <input type="text" name="timeout" placeholder="Timeout" required>
                    <button type="submit" name="add_student" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel