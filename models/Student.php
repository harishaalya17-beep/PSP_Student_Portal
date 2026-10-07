<?php

require_once __DIR__ . '/../config/database.php';

class Student
{
    public static function getAll()
    {
    global $conn;

    $stmt = $conn->prepare(
        "SELECT id, name, ic, program, marks
         FROM students
         ORDER BY id DESC"
    );

    $stmt->execute();

    return $stmt->get_result();
    }

    public static function getById($id)
    {
        global $conn;

        $stmt = $conn->prepare(
            "SELECT id, name, ic, program, marks, password
             FROM students
             WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
    public static function create($name, $ic, $program, $marks, $password)
    {
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO students (name, ic, program, marks, password)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssds",
        $name,
        $ic,
        $program,
        $marks,
        $hashedPassword
    );

    return $stmt->execute();
    }
    public static function update($id, $name, $ic, $program, $marks)
    {
    global $conn;

    $stmt = $conn->prepare(
        "UPDATE students
         SET name = ?, ic = ?, program = ?, marks = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "sssdi",
        $name,
        $ic,
        $program,
        $marks,
        $id
    );

    return $stmt->execute();
    }
    public static function delete($id)
    {
    global $conn;

    $stmt = $conn->prepare(
        "DELETE FROM students
         WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    return $stmt->execute();
    }
}
?>