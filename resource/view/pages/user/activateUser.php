<?php
include '../../../../database/database.php';
include '../../../../function/function.php';
$id = $_GET['id'];
$sql = "UPDATE  users SET status = '1' WHERE id ='$id'";
if ($conn->query($sql) === TRUE) {
    header("location:../main/users.php");
} else {
    echo 'Lỗi';
}