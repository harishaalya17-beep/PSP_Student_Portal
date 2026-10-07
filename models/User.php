<?php

require_once __DIR__ . '/../config/database.php';

class User
{
    public static function findByIC($ic)
    {
        global $conn;

        $stmt = $conn->prepare(
            "SELECT id, name, ic, program, marks, password
             FROM students
             WHERE ic = ?"
        );

        $stmt->bind_param("s", $ic);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
    public static function updatePassword($id, $password)
    {
        global $conn;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
        "UPDATE students
         SET password = ?
         WHERE id = ?"
        );

    $stmt->bind_param("si", $hashedPassword, $id);

    return $stmt->execute();
    }
}
?>