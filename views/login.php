<?php

session_start();

require_once __DIR__ . '/../controllers/AuthController.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ic = trim($_POST["ic"]);
    $password = $_POST["password"];

    if (empty($ic) || empty($password)) {

        $error = "Please enter IC and password.";

    } else {

        $auth = new AuthController();

        if ($auth->login($ic, $password)) {

            header("Location: profile.php");
            exit;

        } else {

            $error = "Invalid IC or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PSP Student Portal - Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4">
                    PSP Student Portal
                </h2>

                <h5 class="text-center mb-4">
                    Student Login
                </h5>

                <?php if ($error != ""): ?>

                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">
                            IC Number
                        </label>

                        <input
                            type="text"
                            name="ic"
                            class="form-control"
                            maxlength="12"
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
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Login
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

</body>

</html>