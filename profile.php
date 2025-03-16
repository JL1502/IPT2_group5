<?php
// Start the session
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include necessary files
include('database/database.php');

// Fetch user data from the database
$user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
$sql = "SELECT id, name, role, email, phone, address FROM users WHERE id = $user_id"; // Ensure all required columns are selected
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result); // Fetch user data
} else {
    die("User not found.");
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update the user's profile in the database
    $update_sql = "UPDATE users SET 
                   name = '$name', 
                   role = '$role', 
                   email = '$email', 
                   phone = '$phone', 
                   address = '$address' 
                   WHERE id = $user_id";

    if (mysqli_query($conn, $update_sql)) {
        // Update session data with the new values
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['address'] = $address;

        // Refresh the page to show updated data
        header("Location: profile.php");
        exit();
    } else {
        die("Error updating profile: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User Profile - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <!-- Include the same header as in your main page -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <!-- Include the same sidebar as in your main page -->
  </aside><!-- End Sidebar -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="assets/img/JLJL.png.jpg" alt="Profile" class="rounded-circle">
              <h2><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></h2>
              <h3><?php echo htmlspecialchars($user['role'] ?? 'N/A'); ?></h3>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Edit Button -->
              <div class="text-end mb-3">
                <button class="btn btn-primary" onclick="toggleEditForm()">Edit Profile</button>
              </div>

              <!-- Profile Details -->
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['name'] ?? 'N/A'); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Role</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['role'] ?? 'N/A'); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></div>
                  </div>
                </div>
              </div><!-- End Profile Details -->

              <!-- Edit Form (Hidden by Default) -->
              <div id="editForm" style="display: none;">
                <h5 class="card-title">Edit Profile</h5>
                <form method="POST" action="">
                  <div class="row mb-3">
                    <label for="name" class="col-lg-3 col-md-4 label">Full Name</label>
                    <div class="col-lg-9 col-md-8">
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="role" class="col-lg-3 col-md-4 label">Role</label>
                    <div class="col-lg-9 col-md-8">
                      <input type="text" class="form-control" id="role" name="role" value="<?php echo htmlspecialchars($user['role'] ?? ''); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="email" class="col-lg-3 col-md-4 label">Email</label>
                    <div class="col-lg-9 col-md-8">
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="phone" class="col-lg-3 col-md-4 label">Phone</label>
                    <div class="col-lg-9 col-md-8">
                      <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="address" class="col-lg-3 col-md-4 label">Address</label>
                    <div class="col-lg-9 col-md-8">
                      <textarea class="form-control" id="address" name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="toggleEditForm()">Cancel</button>
                  </div>
                </form>
              </div><!-- End Edit Form -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <!-- Include the same footer as in your main page -->
  </footer><!-- End Footer -->

  <!-- JavaScript to Toggle Edit Form -->
  <script>
    function toggleEditForm() {
      const editForm = document.getElementById('editForm');
      const profileOverview = document.querySelector('.profile-overview');
      if (editForm.style.display === 'none') {
        editForm.style.display = 'block';
        profileOverview.style.display = 'none';
      } else {
        editForm.style.display = 'none';
        profileOverview.style.display = 'block';
      }
    }
  </script>
</body>
</html>