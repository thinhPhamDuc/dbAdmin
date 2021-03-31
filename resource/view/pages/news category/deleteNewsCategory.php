<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_deleteNewsCategory'];
$sql = "DELETE FROM news_categories WHERE id ='$id'";
deleteNewsCategory($id);
if ($conn->query($sql) === TRUE) {
  echo "<script>window.location = '../main/newsCategory.php';</script>";
} else {
  echo $conn->error;
}