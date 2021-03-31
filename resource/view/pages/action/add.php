<?php
include '../../../../database/database.php';
include '../../../../function/function.php';


if (isset($_POST['add'])) {
  $name = $_POST['name_add'];
  $position = $_POST['position_add'];
  $office = $_POST['office_add'];
  $age = $_POST['age_add'];
  $startDate = $_POST['startDate_add'];
  $salary = $_POST['salary_add'];
  $file_store = uploadImages('../../../../public/admin/assets/images/upload/', '../main/manage-employees.php');

  if ($name !== "" && $startDate !== "" && $salary !== "") {
    $sql = "INSERT INTO employees (name, position, office, age, startDate, salary, images) VALUES ('$name', '$position', '$office', '$age', '$startDate', '$salary', '$file_store')";
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Insert Success'); window.location = '../main/manage-employees.php';</script>";
    } else {
      echo "Error : " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "<script>alert('Please Enter Information'); window.location = '../main/manage-employees.php';</script>";
  }
}