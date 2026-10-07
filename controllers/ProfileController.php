<?php

require_once __DIR__ . '/../config/database.php';

class ProfileController
{
    public function uploadProfilePicture($student_id, $file)
    {
        global $conn;

        // Check if file is selected
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return "Please select a file.";
        }

        // Maximum file size: 2MB
        $maxSize = 2 * 1024 * 1024;

        if ($file['size'] > $maxSize) {
            return "File size must not exceed 2MB.";
        }

        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        // Get file extension
        $fileExtension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        // Check file type
        if (!in_array($fileExtension, $allowedTypes)) {
            return "Only JPG, JPEG and PNG files are allowed.";
        }

        // Generate unique filename
        $newFileName = uniqid() . "." . $fileExtension;

        // Upload folder
        $uploadDirectory = __DIR__ . '/../uploads/profile/';

        // Full file path
        $uploadPath = $uploadDirectory . $newFileName;

        // Move file to upload folder
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return "Failed to upload the file.";
        }

        // Save filename into database
        $stmt = $conn->prepare(
            "UPDATE students
             SET profile_picture = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "si",
            $newFileName,
            $student_id
        );

        if ($stmt->execute()) {
            return true;
        }

        return "Failed to update database.";
    }
}
?>