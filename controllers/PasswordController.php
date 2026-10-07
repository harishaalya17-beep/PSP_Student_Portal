<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Student.php';

class PasswordController
{
    public function changePassword($id, $oldPassword, $newPassword, $confirmPassword)
    {
        $student = Student::getById($id);

        if (!$student) {
            return "Student not found.";
        }

        if (!password_verify($oldPassword, $student['password'])) {
            return "Old password is incorrect.";
        }

        if ($newPassword !== $confirmPassword) {
            return "New password and confirm password do not match.";
        }

        if (strlen($newPassword) < 6) {
            return "New password must be at least 6 characters.";
        }

        if (User::updatePassword($id, $newPassword)) {
            return "success";
        }

        return "Failed to update password.";
    }
}
?>