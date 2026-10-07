<?php

session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../controllers/StudentController.php';

$controller = new StudentController();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid student ID.");
}

$id = (int) $_GET['id'];

$student = $controller->show($id);

if (!$student) {
    die("Student not found.");
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $ic = trim($_POST['ic']);
    $program = trim($_POST['program']);
    $marks = trim($_POST['marks']);

    // Server-side validation
    if ($name == "" || $ic == "" || $program == "" || $marks == "") {

        $message = "Please fill in all fields.";
        $messageType = "danger";

    } elseif (!preg_match("/^[0-9]{12}$/", $ic)) {

        $message = "IC must contain exactly 12 digits.";
        $messageType = "danger";

    } elseif (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $message = "Marks must be between 0 and 100.";
        $messageType = "danger";

    } else {

        if ($controller->update($id, $name, $ic, $program, $marks)) {

            $message = "Student updated successfully!";
            $messageType = "success";

            // Get updated data
            $student = $controller->show($id);

        } else {

            $message = "Failed to update student.";
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

    <title>Edit Student</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="profile.php">
            PSP Student Portal
        </a>

    </div>

</nav>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="mb-4">Edit Student</h3>

                    <?php if ($message != ""): ?>

                        <div class="alert alert-<?php echo $messageType; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?php echo htmlspecialchars($student['name']); ?>"
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
                                value="<?php echo htmlspecialchars($student['ic']); ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Program
                            </label>

                            <input
                                type="text"
                                name="program"
                                class="form-control"
                                value="<?php echo htmlspecialchars($student['program']); ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Marks
                            </label>

                            <input
                                type="number"
                                name="marks"
                                class="form-control"
                                min="0"
                                max="100"
                                step="0.01"
                                value="<?php echo htmlspecialchars($student['marks']); ?>"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Update Student
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