<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../controllers/StudentController.php';

$controller = new StudentController();

$students = $controller->index();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Management</title>

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

        <div>

            <a href="profile.php" class="btn btn-light me-2">
                Profile
            </a>

            <a href="logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</nav>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>
            Student Management
        </h3>

        <a
            href="add_student.php"
            class="btn btn-success"
        >
            + Add Student
        </a>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-primary">

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>IC</th>

                            <th>Program</th>

                            <th>Marks</th>

                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php while ($student = $students->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($student['id']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['name']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['ic']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['program']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($student['marks']) ?>
                            </td>

                            <td>

                                <a
                                    href="edit_student.php?id=<?= $student['id'] ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    Edit
                                </a>

                                <a
                                    href="delete_student.php?id=<?= $student['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirmDelete();"
                                >
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="../assets/js/script.js"></script>

</body>

</html>