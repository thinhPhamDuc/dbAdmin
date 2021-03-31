<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_editUser'];
$firstname = $_POST['firstname_editUser'];
$lastname = $_POST['lastname_editUser'];
$email = $_POST['email_editUser'];
$role_id = $_POST['role_id'];
if ($role_id == '') {
    $role_id = null;
}
$password = $_POST['password_editUser'];
$repassword = $_POST['repassword_editUser'];
$file_store = editImages("../../../../public/admin/assets/images/user/", '../main/users.php', 'users', $id);
if ($firstname === "" || $lastname === "" || $email === "") {
    echo "<script>alert('Không được để rỗng!'); window.location = '../main/users.php';</script>";
} else {
    $update = "UPDATE users SET firstname='$firstname', lastname ='$lastname', email='$email', password = '$password', images='$file_store', role_id ='$role_id'  WHERE id='$id'";

    if ($conn->query($update) === true) {
        echo "<script>window.location = '../main/users.php';</script>";
    } else {
        echo "Lỗi";
    }
}