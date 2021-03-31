<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

session_start();

$id = $_SESSION['user']['id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id' ");
$user = $query->fetch_assoc();
$recentPassword = test_input($_POST['recentPass_pro']);
$newPassword = test_input($_POST['newPass_pro']);
$confirmPassword = test_input($_POST['confirmPass_pro']);
$editOk = 1;
if (!($newPassword) || !($confirmPassword)) {
  echo "<script>alert('Please enter your password!'); window.location='../main/profile.php'; </script>";
}
if ($user['password'] !== md5($recentPassword)) {
  echo "<script>alert('Password Not Right'); window.location='../main/profile.php';</script>";
  $editOk = 0;
}
if ($newPassword !== $confirmPassword) {
  echo "<script>alert('New Password Mismatched'); window.location='../main/profile.php'; </script>";
  $editOk = 0;
}
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z\d]{8,}$/", $newPassword)) {
  echo "<script>alert('Mật khẩu không hợp lệ! (ít nhất 8 ký tự, có số, chữ hoa, chữ thường)'); window.location='../main/profile.php'; </script>";
  $editOk = 0;
}
if ($editOk !== 0) {
  $newPassword = md5($newPassword);
  $sql = "UPDATE users SET password = '$newPassword' WHERE id = '$id' ";
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Password Updated!'); window.location='../main/profile.php'; </script>";
  } else {
    echo "Error Insert: " . $sql . "<br>" . $conn->error;
  }
}