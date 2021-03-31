<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

if (isset($_POST['editProduct'])) {
  $id = $_POST['id_editProduct'];
  $name = $_POST['name_editProduct'];
  $description = $_POST['description_editProduct'];
  $category = $_POST['category_editProduct'];
  $price = $_POST['price_editProduct'];
  $file_store = editImages('../../../../public/admin/assets/images/product/', '../main/product.php', 'products', $id);

  if ($name !== "" || $price !== "" || $category !== "") {
    $sql = "UPDATE products SET name = '$name', description = '$description', category_id = '$category', price = '$price', images = '$file_store' WHERE id = '$id' ";
    if ($conn->query($sql) === TRUE) {
      $tags = $_POST["tags"];
      if (!empty($tags)) {
        $sql = "SELECT * FROM link_product_tag WHERE product_id = " . $id;
        $result = $conn->query($sql);
        $tag_select = [];
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $tag_select[$row['tag_id']] = $row['tag_id'];
          }
        }
        foreach ($tags as $tag_id) {
          $sql = "SELECT * FROM link_product_tag WHERE product_id = " . $id . " AND tag_id = " . $tag_id;
          $result = $conn->query($sql);
          if ($result->num_rows === 0) {
            $sql = "INSERT INTO link_product_tag (product_id, tag_id) VALUES ('$id', '$tag_id')";
            $conn->query($sql);
          }
          unset($tag_select[$tag_id]);
        }
        if (!empty($tag_select)) {
          $sql = "DELETE FROM link_product_tag WHERE product_id = " . $id . " AND tag_id in (";
          $arr = [];
          foreach ($tag_select as $v) {
            $arr[] = $v;
          }
          foreach ($arr as $k => $tag_id) {
            if ($k === 0) {
              $sql .= $tag_id;
            } else {
              $sql .= ',' . $tag_id;
            }
          }
          $sql .= ')';
          $conn->query($sql);
        }
      } else {
        $sql = "DELETE FROM link_product_tag WHERE product_id = " . $id;
        $conn->query($sql);
      }
      echo "<script >alert('Data Updated'); window.location='../main/product.php'</script>";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
  } else {
    echo "<script>alert('Không được để rỗng!'); window.location = '../main/product.php';</script>";
  }
}