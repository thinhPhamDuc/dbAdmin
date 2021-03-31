<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST["id_editNewsTag"];
$name = test_input($_POST["name_editNewsTag"]);

if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/newsTag.php';</script>";
}

$update = "UPDATE news_tag SET name='$name' WHERE id='$id'";

if ($conn->query($update) === true) {
  echo "<script>window.location = '../main/newsTag.php';</script>";
} else {
  echo "Lỗi";
}