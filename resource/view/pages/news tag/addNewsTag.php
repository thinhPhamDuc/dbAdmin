<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$name = test_input($_POST["name_addNewsTag"]);

if ($name === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/newsTag.php';</script>";
} else {
  $add = "INSERT INTO news_tag (name) VALUES ('$name')";
  if ($conn->query($add) === true) {
    echo "<script>window.location = '../main/newsTag.php';</script>";
  } else {
    echo "<script>alert('Lỗi!')</script>";
  }
}