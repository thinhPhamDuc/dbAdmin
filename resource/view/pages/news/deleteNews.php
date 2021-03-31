<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_deleteNews'];
$sql = "DELETE FROM news WHERE id ='$id'";
$sql1 = "SELECT * FROM news WHERE id = '$id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
if ($row['images']) {
  unlink($row['images']);
}
if ($conn->query($sql) === TRUE) {
  echo "<script>window.location = '../main/news.php';</script>";
} else {
  echo $conn->error;
}