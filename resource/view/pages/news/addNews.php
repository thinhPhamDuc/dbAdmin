<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include '../../../../database/database.php';
include '../../../../function/function.php';

$title = test_input($_POST['title_addNews']);
$description = test_input($_POST['description_addNews']);
$content = mysqli_real_escape_string($conn, $_POST["content_addNews"]);
$author = test_input($_POST['author_addNews']);
$category = test_input($_POST['category_addNews']);
$file_store = uploadImages('../../../../public/admin/assets/images/news/', '../main/news.php');
if ($title === "" || $description === "" || $content === "" || $category === "") {
  echo "<script>alert('Không được để rỗng!'); window.location = '../main/news.php';</script>";
} else {
  $time = date('Y-m-d H:i:s');
  $add = "INSERT INTO news (title, description, content, author, category_id, date, images) VALUES ('$title', '$description', '$content', '$author', '$category', '$time', '$file_store')";

  if ($conn->query($add) === true) {
    //  Lấy product_id của bản ghi vừa tạo mới
    $sql = "SELECT * FROM `news` ORDER BY id DESC LIMIT 1";
    $news = $conn->query($sql);
    $news = $news->fetch_array();

    $news_id = $news['id'];

    //  Gắn tags cho sản phẩm
    $tags = $_POST["tags"];
    if (!empty($tags)) {
      foreach ($tags as $tag_id) {
        $sql = "INSERT INTO link_news_tag (news_id, tag_id) VALUES ('$news_id', '$tag_id')";
        $conn->query($sql);
      }
    }

    echo "<script>window.location = '../main/news.php';</script>";
  } else {
    echo "<script>alert('Lỗi!')</script>";
  }
}