<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_GET['id'];
$update = "UPDATE users SET images = '' WHERE id='$id'";
$sql1 = "SELECT * FROM users WHERE id = '$id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
unlink($row['images']);
if ($conn->query($update) === TRUE) {
    echo "<script>alert('Đã xóa ảnh'); window.location = '../main/profile.php';</script>";
} else {
    echo $conn->error;
}