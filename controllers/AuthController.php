<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login($ic, $password)
    {
        $user = User::findByIC($ic);

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['name'];
            $_SESSION['student_ic'] = $user['ic'];
            $_SESSION['student_program'] = $user['program'];

            return true;
        }

        return false;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: ../views/login.php");
        exit;
    }
}
?>