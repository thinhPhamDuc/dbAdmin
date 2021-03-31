<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$name = test_input($_POST["name_addNewsCategory"]);
$category = test_input($_POST['category_addNewsCategory']);

$query = mysqli_query($conn, "SELECT * FROM news_categories where name='$name'");
if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/newsCategory.php';</script>";
  die;
} else if ($query) {
  if ($query->num_rows > 0) {
    echo "<script>alert('Danh mục đã tồn tại!'); window.location = '../main/newsCategory.php';</script>";
  }
  die;
}

$add = "INSERT INTO news_categories (name,parent_id) VALUES ('$name', '$category')";
if ($conn->query($add) === true) {
  echo "<script>window.location = '../main/newsCategory.php';</script>";
} else {
  echo "<script>alert('Lỗi!')</script>";
}