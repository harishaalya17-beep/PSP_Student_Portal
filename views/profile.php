<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

$student_id = $_SESSION['student_id'];

$uploadMessage = "";

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['profile_picture'])) {

        $controller = new ProfileController();

        $result = $controller->uploadProfilePicture(
            $student_id,
            $_FILES['profile_picture']
        );

        if ($result === true) {

            $uploadMessage = "Profile picture uploaded successfully.";

        } else {

            $uploadMessage = $result;

        }
    }
}


// Get current profile picture
$stmt = $conn->prepare(
    "SELECT profile_picture
     FROM students
     WHERE id = ?"
);

$stmt->bind_param("i", $student_id);

$stmt->execute();

$result = $stmt->get_result();

$student = $result->fetch_assoc();

$profile_picture = $student['profile_picture'] ?? "";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <span class="navbar-brand">
            PSP Student Portal
        </span>

        <a
            href="logout.php"
            class="btn btn-light"
        >
            Logout
        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-4">
                Student Profile
            </h3>


            <!-- Success / Error Message -->

            <?php if (!empty($uploadMessage)): ?>

    <div class="alert <?= $uploadMessage === 'Profile picture uploaded successfully.' ? 'alert-success' : 'alert-danger' ?>">

        <?= htmlspecialchars($uploadMessage) ?>

    </div>

<?php endif; ?>


            <!-- Profile Picture -->

            <?php if (!empty($profile_picture)): ?>

                <div class="text-center mb-4">

                    <img
                        src="../uploads/profile/<?= htmlspecialchars($profile_picture) ?>"
                        alt="Profile Picture"
                        width="150"
                        height="150"
                        style="
                            object-fit: cover;
                            border-radius: 50%;
                        "
                    >

                </div>

            <?php endif; ?>


            <!-- Upload Profile Picture -->

            <form
                method="POST"
                enctype="multipart/form-data"
                class="mb-4"
            >

                <label class="form-label">

                    <strong>
                        Upload Profile Picture
                    </strong>

                </label>


                <input
                    type="file"
                    name="profile_picture"
                    class="form-control"
                    required
                >


                <small class="text-muted">

                    JPG, JPEG or PNG only.
                    Maximum file size: 2MB.

                </small>


                <br><br>


                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    Upload Picture

                </button>

            </form>


            <!-- Student Information -->

            <div class="mb-3">

                <strong>Name:</strong>

                <?= htmlspecialchars($_SESSION['student_name']) ?>

            </div>


            <div class="mb-3">

                <strong>NRIC:</strong>

                <?= htmlspecialchars($_SESSION['student_ic']) ?>

            </div>


            <div class="mb-3">

                <strong>Program:</strong>

                <?= htmlspecialchars($_SESSION['student_program']) ?>

            </div>


            <!-- Change Password -->

            <a
                href="password.php"
                class="btn btn-warning"
            >

                Change Password

            </a>


        </div>

    </div>

</div>


</body>

</html>