<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_deleteUser'];
$sql = "DELETE FROM users WHERE id ='$id'";
$sql1 = "SELECT * FROM users WHERE id = '$id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
if ($row['images']) {
    unlink($row['images']);
}
if ($conn->query($sql) === TRUE) {
    echo "<script>window.location = '../main/users.php';</script>";
} else {
    echo $conn->error;
}