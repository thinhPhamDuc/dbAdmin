<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST["id_editProductCategory"];
$name = test_input($_POST["name_editProductCategory"]);

$sql = mysqli_query($conn, "SELECT * FROM product_categories where name='$name'");
if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/productCategory.php';</script>";
  die;
} else if ($sql) {
  if ($sql->num_rows > 0) {
    echo "<script>alert('Danh mục đã tồn tại!'); window.location = '../main/productCategory.php';</script>";
  }
  die;
}

$update = "UPDATE product_categories SET name='$name' WHERE id='$id'";
if ($conn->query($update) === true) {
  echo "<script>window.location = '../main/productCategory.php';</script>";
} else {
  echo "Lỗi";
}