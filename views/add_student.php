<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../controllers/StudentController.php';

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $ic = trim($_POST["ic"]);
    $program = trim($_POST["program"]);
    $marks = trim($_POST["marks"]);
    $password = $_POST["password"];

    if (
        empty($name) ||
        empty($ic) ||
        empty($program) ||
        $marks === "" ||
        empty($password)
    ) {

        $message = "Please fill in all fields.";
        $messageType = "danger";

    } elseif (!preg_match("/^[0-9]{12}$/", $ic)) {

        $message = "IC must contain exactly 12 digits.";
        $messageType = "danger";

    } elseif (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $message = "Marks must be between 0 and 100.";
        $messageType = "danger";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $messageType = "danger";

    } else {

        $controller = new StudentController();

        if (
            $controller->create(
                $name,
                $ic,
                $program,
                $marks,
                $password
            )
        ) {

            $message = "Student added successfully.";
            $messageType = "success";

        } else {

            $message = "Failed to add student. IC may already exist.";
            $messageType = "danger";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

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

        <a href="profile.php" class="btn btn-light">
            Profile
        </a>

    </div>

</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="mb-4">
                        Add New Student
                    </h3>

                    <?php if ($message != ""): ?>

                        <div class="alert alert-<?= $messageType ?>">
                            <?= htmlspecialchars($message) ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Student Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                IC Number
                            </label>

                            <input
                                type="text"
                                name="ic"
                                class="form-control"
                                maxlength="12"
                                pattern="[0-9]{12}"
                                required
                            >

                            <small class="text-muted">
                                Enter exactly 12 digits.
                            </small>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Program
                            </label>

                            <input
                                type="text"
                                name="program"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Marks
                            </label>

                            <input
                                type="text"
                                name="marks"
                                class="form-control"
                                required
                            
                            >
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                minlength="6"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Add Student
                        </button>

                        <a
                            href="students.php"
                            class="btn btn-secondary"
                        >
                            Back
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>