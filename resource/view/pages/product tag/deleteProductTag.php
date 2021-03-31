<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['id_deleteProductTag'];
$sql = "DELETE FROM product_tag WHERE id = '$id' ";
if ($conn->query($sql) === TRUE) {
  echo "<script>window.location = '../main/productTag.php';</script>";
} else {
  echo 'Error';
}