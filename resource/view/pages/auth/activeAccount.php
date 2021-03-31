<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$email = $_GET['email'];
$time = $_GET['time'];
$now = time();

$time_invalid = $now - (60 * 60 * 24 * 3);
if (strtotime($time) > $time_invalid) {
  $sql = "UPDATE users SET active = 1, is_active = 1 WHERE email = '$email' && created_at ='$time' ";
  $sql .= " and is_active = 0";
  $query = mysqli_query($conn, $sql);
}

header('Location: login.php');