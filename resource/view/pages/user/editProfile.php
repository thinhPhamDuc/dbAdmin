<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_POST['userId_pro'];
if (isset($_POST['editUser'])) {
  $firstname = $_POST['firstname_pro'];
  $lastname = $_POST['lastname_pro'];
  $email = $_POST['email_pro'];
  $file_store = editImages('../../../../public/admin/assets/images/user/', '../main/profile.php', 'users', $id);

  if ($firstname === "" || $lastname === "" || $email === "") {
    echo "<script>alert('Không thể để rỗng.'); window.location = '../main-view/userProfile.php';</script>";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Email không đúng định dạng.'); window.location = '../main-view/userProfile.php';</script>";
  } else {
    $update = "UPDATE users SET firstname='$firstname', lastname ='$lastname', email ='$email', images ='$file_store'  WHERE id='$id'";
    if ($conn->query($update) === true) {
      echo "<script>window.location = '../main-view/userProfile.php';</script>";
    } else {
      echo "Lỗi";
    }
  }
}