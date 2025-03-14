<?php
include('partials/header.php');
include('partials/sidebar.php');
include('database/database.php');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_student'])) {
        // Add Student
        $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $timein = mysqli_real_escape_string($conn, $_POST['timein']);
        $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);

        $sql = "INSERT INTO attendance (student_name, student_id, timein, timeout) VALUES ('$student_name', '$student_id', '$timein', '$timeout')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Student added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding Student: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['edit_attendance'])) {
        // Edit Attendance
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $timein = mysqli_real_escape_string($conn, $_POST['timein']);
        $timeout = mysqli_real_escape_string($conn, $_POST['timeout']);

        $sql = "UPDATE attendance SET student_name='$student_name', student_id='$student_id', timein='$timein', timeout='$timeout' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Student updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating student: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['delete_student'])) {
        // Delete Student
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        $sql = "DELETE FROM attendance WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Student deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting student: " . mysqli_error($conn) . "');</script>";
        }
    }
}

// Fetch attendance records from the database
$sql = "SELECT * FROM attendance";
$result = mysqli_query($conn, $sql);
$attendance = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Rest of your HTML and JavaScript code remains the same -->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Attendance Management System</h1>
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
                                <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
                            </div>
                        </div>

                        <!-- Student Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Time In</th>
                                    <th scope="col">Time Out</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendance as $student): ?>
                                    <tr>
                                        <th scope="row"><?php echo $student['id']; ?></th>
                                        <td><?php echo $student['student_id']; ?></td>
                                        <td><?php echo $student['student_name']; ?></td>
                                        <td><?php echo $student['timein']; ?></td>
                                        <td><?php echo $student['timeout']; ?></td>
                                        <td class="text-center">
    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal" onclick="editStudent(<?php echo $student['id']; ?>)">Edit</button>
    <form method="POST" action="" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        <button type="submit" name="delete_student" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</button>
    </form>
</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Student Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Student Name" required>
                    </div>
                    <div class="mb-3">
    <label for="timein" class="form-label">Time In</label>
    <input type="time" class="form-control" id="timein" name="timein" required>
</div>
<div class="mb-3">
    <label for="timeout" class="form-label">Time Out</label>
    <input type="time" class="form-control" id="timeout" name="timeout" required>
</div>
                    <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <input type="hidden" name="id" id="edit_id"> <!-- Hidden field for student ID -->
                    <div class="mb-3">
                        <label for="edit_student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="edit_student_id" name="student_id" placeholder="Student ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_student_name" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="edit_student_name" name="student_name" placeholder="Student Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_timein" class="form-label">Time In</label>
                        <input type="time" class="form-control" id="edit_timein" name="timein" placeholder="Time In" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_timeout" class="form-label">Time Out</label>
                        <input type="time" class="form-control" id="edit_timeout" name="timeout" placeholder="Time Out" required>
                    </div>
                    <button type="submit" name="edit_attendance" class="btn btn-primary">Update Attendance</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include('partials/footer.php');
?>