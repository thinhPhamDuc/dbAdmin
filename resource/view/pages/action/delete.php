<?php
include '../../../../database/database.php';

if (isset($_POST['delete'])) {
  $id = $_POST['id_del'];
  $sql1 = "SELECT * FROM employees WHERE id ='$id' ";
  $row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
  unlink($row['images']);
  $sql = "DELETE FROM employees WHERE id = '$id' ";
  if ($conn->query($sql) === TRUE) {
    header('Location: ../main/manage-employees.php');
  } else {
    echo '("Delete not succesfully")' . $conn->error;
  }
}