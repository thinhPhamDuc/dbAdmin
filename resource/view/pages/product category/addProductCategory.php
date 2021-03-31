<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$name = test_input($_POST['name_addProductCategory']);
$category = test_input($_POST['category_addProductCategory']);

$query = mysqli_query($conn, "SELECT * FROM product_categories WHERE name = '$name' ");
if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/productCategory.php';</script>";
} else if ($query->num_rows > 0) {
  echo "<script>alert('Danh mục đã tồn tại!'); window.location = '../main/productCategory.php';</script>";
} else {
  $sql = "INSERT INTO product_categories (name, parent_id) VALUES ('$name', '$category')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>window.location = '../main/productCategory.php';</script>";
  } else {
    echo "Error";
  }
}