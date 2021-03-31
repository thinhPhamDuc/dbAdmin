<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$name = test_input($_POST['name_addProductTag']);

if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/productTag.php';</script>";
} else {
  $sql = "INSERT INTO product_tag (name) VALUES ('$name')";
  if ($conn->query($sql) === TRUE) {
    echo "<script>window.location = '../main/productTag.php';</script>";
  } else {
    echo "<script>alert('Lỗi!')</script>";
  }
}