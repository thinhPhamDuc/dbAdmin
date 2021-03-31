<?php
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function getProductCategory($category_id)
{
  include '../../../../database/database.php';
  $sql = "SELECT * FROM product_categories WHERE id = " . $category_id;
  $categories = $conn->query($sql);

  if (is_object($categories)) {
    if ($categories->num_rows > 0) {
      $category = $categories->fetch_array();
      return $category;
    }
  }
  return false;
}
function getNewsCategory($category_id)
{
  include '../../../../database/database.php';
  $sql = "SELECT * FROM news_categories WHERE id = " . $category_id;
  $categories = $conn->query($sql);

  if (is_object($categories)) {
    if ($categories->num_rows > 0) {
      $category = $categories->fetch_array();
      return $category;
    }
  }
  return false;
}
function getProductTags($product_id)
{
  include '../../../../database/database.php';
  $sql = "SELECT product_tag.id, product_tag.name FROM product_tag INNER JOIN link_product_tag ON link_product_tag.tag_id = product_tag.id INNER JOIN products ON link_product_tag.product_id = products.id WHERE products.id = " . $product_id;
  $result = $conn->query($sql);

  $tags = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $tags[] = $row;
    }
  }
  return $tags;
}
function getNewsTags($news_id)
{
  include '../../../../database/database.php';
  $sql = "SELECT news_tag.id, news_tag.name FROM news_tag INNER JOIN link_news_tag ON link_news_tag.tag_id = news_tag.id INNER JOIN news ON link_news_tag.news_id = news.id WHERE news.id = " . $news_id;
  $result = $conn->query($sql);

  $tags = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $tags[] = $row;
    }
  }
  return $tags;
}
function productCategoryTree($parent_id = 0, $sub_mark = "")
{
  include '../../../../database/database.php';
  $sql = "SELECT * FROM product_categories WHERE parent_id = $parent_id ORDER BY name ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['id'] . '">' . $sub_mark . $row['name'] . '</option>';
      productCategoryTree($row['id'], $sub_mark . '--');
    }
  }
}
function newsCategoryTree($parent_id = 0, $sub_mark = "")
{
  include '../../../../database/database.php';
  $sql = "SELECT * FROM news_categories WHERE parent_id = $parent_id ORDER BY name ASC";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row['id'] . '">' . $sub_mark . $row['name'] . '</option>';
      newsCategoryTree($row['id'], $sub_mark . '--');
    }
  }
}
function deleteProductCategory($parent_id)
{
  include '../../../../database/database.php';
  $sql2 = "SELECT * FROM product_categories WHERE parent_id = $parent_id ORDER BY name ASC";
  $result = $conn->query($sql2);
  $sql = "DELETE FROM product_categories WHERE parent_id = $parent_id";
  if ($conn->query($sql) === TRUE) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        deleteProductCategory($row['id']);
      }
    }
  }
}
function deleteNewsCategory($parent_id)
{
  include '../../../../database/database.php';
  $sql2 = "SELECT * FROM news_categories WHERE parent_id = $parent_id ORDER BY name ASC";
  $result = $conn->query($sql2);
  $sql = "DELETE FROM news_categories WHERE parent_id = $parent_id";
  if ($conn->query($sql) === TRUE) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        deleteNewsCategory($row['id']);
      }
    }
  }
}
function getRole($role_id)
{
  include '../../../../database/database.php';
  $sql = "SELECT * FROM roles WHERE id = " . $role_id;
  $roles = $conn->query($sql);
  if (is_object($roles)) {
    if ($roles->num_rows > 0) {
      $role = $roles->fetch_array();
      return $role;
    }
  }
  return false;
}
function checkPer($user_id, $per_code)
{
  include '../../../../database/database.php';
  $sql = "SELECT link_role_permission.* FROM link_role_permission INNER JOIN permissions ON permissions.id = link_role_permission.permission_id INNER JOIN roles ON roles.id = link_role_permission.role_id INNER JOIN users ON users.role_id = roles.id WHERE users.id = '$user_id' && permissions.code = '$per_code' ";
  $result = $conn->query($sql);
  if (!$result) {
    return false;
  }
  if ($result->num_rows > 0) {
    return true;
  }
  return false;
}

function uploadImages($folder, $location)
{
  $file_name = uniqid() . "." . pathinfo($_FILES['fileImages']['name'], PATHINFO_EXTENSION);
  $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  $file_size = $_FILES['fileImages']['size'];
  $file_tem_loc = $_FILES['fileImages']['tmp_name'];
  $file_store = $folder . $file_name;
  $uploadOk = 1;

  if (!is_uploaded_file($file_tem_loc)) {
    $file_store = null;
  } else {
    if (($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
      && $file_type != "gif")) {
      echo "<script>alert('Xin lỗi, chỉ chấp nhận JPG, JPEG, PNG & GIF.'); window.location = $location;</script>";
      $uploadOk = 0;
    }
    if ($file_size > 500000) {
      echo "<script>alert('Xin lỗi, ảnh của bạn quá lớn.'); window.location = $location;</script>";
      $uploadOk = 0;
    }
    if ($uploadOk !== 0) {
      move_uploaded_file($file_tem_loc, $file_store);
    }
  }
  return $file_store;
}

function editImages($folder, $location, $table, $id)
{
  include '../../../../database/database.php';
  $file_name = uniqid() . "." . pathinfo($_FILES['fileImages']['name'], PATHINFO_EXTENSION);
  $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  $file_size = $_FILES['fileImages']['size'];
  $file_tem_loc = $_FILES['fileImages']['tmp_name'];
  $file_store = $folder . $file_name;
  $uploadOk = 1;

  if (!is_uploaded_file($file_tem_loc)) {
    $query = mysqli_query($conn, "SELECT images FROM $table where id='$id'");
    $row = $query->fetch_assoc();
    $file_store = $row['images'];
  } else {
    if (($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
      && $file_type != "gif" && $file_type != "webp")) {
      echo "<script>alert('Xin lỗi, chỉ chấp nhận JPG, JPEG, PNG & GIF.'); window.location = $location;</script>";
      $uploadOk = 0;
    }
    if ($file_size > 500000) {
      echo "<script>alert('Xin lỗi, ảnh của bạn quá lớn.'); window.location = $location;</script>";
      $uploadOk = 0;
    }
    if ($uploadOk !== 0) {
      $sql1 = "SELECT * FROM $table WHERE id = '$id'";
      $row = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
      if ($row['images']) {
        unlink($row['images']);
      }
      move_uploaded_file($file_tem_loc, $file_store);
    }
  }
  return $file_store;
}