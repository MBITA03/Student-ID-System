<?php
require 'dbconfig.php';

$exam_no = $_POST['exam_no_search'];
$uploadOption = $_POST['uploadOption'];
$photoPath = null;

if ($uploadOption === 'file' && isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] !== '') {
    // Handle file upload
    $photoPath = 'photos/' . basename($_FILES['photo']['name']);
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
        // File successfully uploaded to the 'photos' directory
    } else {
        die("Error uploading file.");
    }
} elseif ($uploadOption === 'capture' && isset($_POST['capturedImage'])) {
    // Handle captured image (base64)
    $capturedImage = $_POST['capturedImage'];
    $photoPath = saveBase64Image($capturedImage, $exam_no);
}

if ($photoPath !== null) {
    // Update the database with the photo path
    $sql = "UPDATE students SET photo = ? WHERE exam_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $photoPath, $exam_no);

    if ($stmt->execute()) {
        echo "Image saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No image provided.";
}

$conn->close();

function saveBase64Image($base64String, $exam_no) {
    // Decode the base64 string and save it as an image in the 'photos' directory
    $data = explode(',', $base64String);
    $imageData = base64_decode($data[1]);
    $photoPath = 'photos/' . $exam_no . '_captured.png';
    file_put_contents($photoPath, $imageData);
    return $photoPath;
}
?>
