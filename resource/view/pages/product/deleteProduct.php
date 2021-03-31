<?php
include '../../../../database/database.php';

if (isset($_POST['deleteProduct'])) {
  $id = $_POST['id_deleteProduct'];
  $sql1 = "SELECT * FROM products WHERE id = '$id' ";
  $row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
  unlink($row['images']);
  $sql = "DELETE FROM products WHERE id = '$id' ";
  if ($conn->query($sql) === TRUE) {
    header('Location: ../main/product.php');
  } else {
    echo '("Delete not succesfully")' . $conn->error;
  }
}