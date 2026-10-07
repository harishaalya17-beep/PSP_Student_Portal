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

if ($controller->delete($id)) {
    header("Location: students.php?message=deleted");
    exit;
} else {
    die("Failed to delete student.");
}

?>