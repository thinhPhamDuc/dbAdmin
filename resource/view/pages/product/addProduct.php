<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

if (isset($_POST['addProduct'])) {
  $name = $_POST['name_addProduct'];
  $description = $_POST['description_addProduct'];
  $price = $_POST['price_addProduct'];
  $category = $_POST['category_addProduct'];
  $file_store = uploadImages('../../../../public/admin/assets/images/product/', '../main/product.php');

  if ($name !== "" && $description !== "" && $price !== "" && $category !== "") {
    $sql = "INSERT INTO products (name, description, category_id, price, images) VALUES ('$name', '$description', '$category', '$price', '$file_store')";
    if ($conn->query($sql) === TRUE) {
      $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 1";
      $products = $conn->query($sql);
      $products = $products->fetch_array();
      $product_id = $products['id'];
      $tags = $_POST['tags'];
      if (!empty($tags)) {
        foreach ($tags as $tag_id) {
          $sql = "INSERT INTO link_product_tag (product_id, tag_id) VALUES ('$product_id', '$tag_id')";
          $conn->query($sql);
        }
      }
      echo "<script>alert('Insert Success'); window.location='../main/product.php';</script>";
    } else {
      echo "Error : " . $sql . "<br>" . $conn->error;
    }
  } else {
    echo "<script>alert('Please Enter Information'); window.location='../main/product.php';</script>";
  }
}