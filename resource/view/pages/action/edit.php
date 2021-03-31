<?php
include '../../../../database/database.php';

if (isset($_POST['update'])) {
  $id = $_POST['id_upd'];
  $name = $_POST['name_upd'];
  $position = $_POST['position_upd'];
  $office = $_POST['office_upd'];
  $age = $_POST['age_upd'];
  $startDate = $_POST['startDate_upd'];
  $salary = $_POST['salary_upd'];
  $file_type = strtolower(pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION));
  $file_size = $_FILES['fileUpload']['size'];
  $file_tem_loc = $_FILES['fileUpload']['tmp_name'];
  $file_store = "../../../../public/admin/assets/images/upload/";
  $uploadOk = 1;

  if (is_uploaded_file($file_tem_loc)) {
    $file_name = uniqid() . "." . pathinfo($_FILES['fileUpload']['name'], PATHINFO_EXTENSION);
    $file_store = "../../../../public/admin/assets/images/upload/" . $file_name;
    if ($file_type !== "jpg" && $file_type !== "png" && $file_type !== "jpeg" && $file_type !== "gif") {
      echo "<script>alert('Sorry, Only JPG, JPEG, PNG & GIF files are allowed..'); window.location='../main/manage-employees.php';</script>";
      $uploadOk = 0;
    }
    if ($file_size > 500000) {
      echo "<script>alert('Sorry, File size is too large.'); window.location='../main/manage-employees.php';</script>";
      $uploadOk = 0;
    } else {
      $sql1 = "SELECT * FROM employees WHERE id = '$id'";
      $row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
      if ($row['images']) {
        unlink($row['images']);
      }
    }
  }

  if (!is_uploaded_file($file_tem_loc)) {
    $sql = "UPDATE employees SET name = '$name', position = '$position', office = '$office', age = '$age', startDate = '$startDate', salary = '$salary' WHERE id = '$id' ";
    if ($conn->query($sql) === TRUE) {
      echo "<script >alert('Data Updated'); window.location='../main/manage-employees.php'</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  if ($uploadOk !== 0) {
    move_uploaded_file($file_tem_loc, $file_store);
    $sql = "UPDATE employees SET name = '$name', position = '$position', office = '$office', age = '$age', startDate = '$startDate', salary = '$salary', images = '$file_store' WHERE id = '$id' ";
    if ($conn->query($sql) === TRUE) {
      echo "<script >alert('Data Updated'); window.location='../main/manage-employees.php'</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  }
}