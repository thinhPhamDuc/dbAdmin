<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST["id_editNewsCategory"];
$name = test_input($_POST["name_editNewsCategory"]);
$sql = mysqli_query($conn, "SELECT * FROM news_categories where name='$name'");
if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/newsCategory.php';</script>";
  die;
} else if ($sql) {
  if ($sql->num_rows > 0) {
    echo "<script>alert('Danh mục đã tồn tại!'); window.location = '../main/newsCategory.php';</script>";
  }
  die;
}

$update = "UPDATE news_categories SET name='$name' WHERE id='$id'";
if ($conn->query($update) === true) {
  echo "<script>window.location = '../main/newsCategory.php';</script>";
} else {
  echo "Lỗi";
}