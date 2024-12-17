<?php
require 'dbconfig.php';

$exam_no = $_POST['exam_no'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$sex = $_POST['sex'];

$sql = "INSERT INTO students (exam_no, first_name, last_name, dob, sex) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $exam_no, $first_name, $last_name, $dob, $sex);

if ($stmt->execute()) {
    echo "Student details saved successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
