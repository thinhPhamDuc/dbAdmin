<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$firstname = test_input($_POST["firstname_addUser"]);
$lastname = test_input($_POST["lastname_addUser"]);
$email = test_input($_POST["email_addUser"]);
$role_id = $_POST['role_id'];
if ($role_id == '') {
    $role_id = null;
}
$password = test_input($_POST["password_addUser"]);
$repassword = test_input($_POST["repassword_addUser"]);
date_default_timezone_set("Asia/Ho_Chi_Minh");
$time = date('Y-m-d H:i:sa');

if ($firstname === "" || $lastname === "" || $email === "") {
    echo "<script>alert('Không được để tên, họ và email rỗng!'); window.location = '../main/users.php';</script>";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Email không đúng định dạng!'); window.location = '../main/users.php';</script>";
}
if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)) {
    echo "<script>alert('Mật khẩu phải có ít nhất 8 ký tự, có chữ hoa, chữ thường và số!'); window.location = '../main/users.php';</script>";
}
if ($password !== $repassword) {
    echo "<script>alert('Mật khẩu đã nhập không giống nhau!'); window.location = '../main/users.php';</script>";
}
$file_store = uploadImages("../../../../public/admin/assets/images/user/", '../main/users.php');
$md5Password = md5($password);
$add = "INSERT INTO users (firstname, lastname, email, password, images, role_id, is_active, active, created_at) VALUES ('$firstname', '$lastname', '$email','$md5Password','$file_store','$role_id', 1, 1, '$time')";
if ($conn->query($add) === true) {
    echo "<script>window.location = '../main/users.php';</script>";
} else {
    echo "<script>alert('Người dùng không được thêm!'); window.location = '../main/users.php';</script>";
}