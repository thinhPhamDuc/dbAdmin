<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_deleteNewsTag'];
$sql = "DELETE FROM news_tag WHERE id ='$id'";
if ($conn->query($sql) === TRUE) {
  echo "<script>window.location = '../main/newsTag.php';</script>";
} else {
  echo $conn->error;
}