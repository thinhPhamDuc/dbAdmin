<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../auth/login.php');
}

include '../../../../database/database.php';
include '../../../../function/function.php';

$id = $_SESSION["user"]["id"];
$query = mysqli_query($conn, "SELECT * FROM users where id='$id'");
$user = $query->fetch_assoc();
if (!checkPer($user['id'], 'post_view')) {
  header('Location:../error/404.php');
}


$sql = "SELECT * FROM news";

$result = $conn->query($sql);

$sql = "SELECT * FROM news_categories ORDER BY id DESC";
$categories = $conn->query($sql);

$sql = "SELECT * FROM news_tag ORDER BY name ASC";
$tags = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>News - Dashboard Admin</title>
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">
</head>

<body class="sb-nav-fixed">
  <!-- ///========= Add Modal =========/// -->
  <div class="modal fade" id="addNews">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../news/addNews.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Add News</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group position-relative text-center">
              <img class="form__img" src="../../../../public/admin/assets/images/news/default.png" width="100">
              <label for="fileImages" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileImages" id="fileImages">
              </label>
            </div>
            <div class="form-group">
              <label for="title_addNews">Title:</label>
              <input type="text" name="title_addNews" id="title_addNews" class="form-control">
            </div>
            <div class="form-group">
              <label for="description_addNews">Description:</label>
              <input type="text" name="description_addNews" id="description_addNews" class="form-control">
            </div>
            <div class="form-group">
              <label for="content_addNews">Content:</label>
              <textarea type="text" name="content_addNews" id="content_addNews" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <label for="author_addNews">Author:</label>
              <input type="text" name="author_addNews" id="author_addNews" class="form-control">
            </div>
            <div class="form-group">
              <label for="category_addNews">Categories:</label>
              <select name="category_addNews" id="category_addNews" class="form-control">
                <?php
                echo newsCategoryTree();
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tags_addNews">Tags:</label>
              <?php
              $list_tags = [];
              if ($tags->num_rows > 0) {
                while ($row = $tags->fetch_assoc()) {
                  echo '<label style="display: block;"><input style="margin-right: 5px;" name="tags[]" type="checkbox" value="' . $row['id'] . '">' . $row['name'] .  '</label>';
                  $list_tags[] = $row;
                }
              }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addNews" class="btn btn-primary">Add</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Delete Modal =========/// -->
  <div class="modal fade" id="deleteNews">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../news/deleteNews.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Delete News</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Are you sure?</h5>
            <input type="hidden" id="id_deleteNews" name="id_deleteNews">
            <div class="form-group">
              <input type="hidden" name="fileImages" id="fileImages">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="deleteNews" class="btn btn-danger">Delete</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include '../../partial/header.php' ?>
  <div id="layoutSidenav">
    <?php include '../../partial/sidenav.php' ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">News</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">News</li>
          </ol>
          <button data-toggle="modal" data-target="#addNews" class="btn btn-primary addNewsBtn mb-2">New
            News</button>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              News Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Author</th>
                      <th>Category</th>
                      <th>Tags</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Author</th>
                      <th>Category</th>
                      <th>Tags</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                      <td style="display: none;"><?php echo $row['id']; ?></td>
                      <td class="imgNewsBtn text-center"><img src="<?php if ($row['images']) {
                                                                          echo $row['images'];
                                                                        } else {
                                                                          echo '../../../../public/admin/assets/images/news/default.png';
                                                                        } ?>" width="100" alt="">
                      </td>
                      <td><?php echo $row['title']; ?></td>
                      <td><?php echo $row['description']; ?></td>
                      <td><?php echo $row['author']; ?></td>
                      <?php
                          $cate = getNewsCategory($row['category_id']);
                          ?>
                      <td class="field-category" data-category_id="<?php if ($cate['id']) echo $cate['id'] ?>">
                        <?php if ($cate['name']) echo $cate['name'] ?></td>
                      <?php
                          $tags = getNewsTags($row['id']);
                          ?>
                      <td class="field-tag" data-tag_id="<?php foreach ($tags as $tag) {
                                                                if ($tag['id']) {
                                                                  echo $tag['id'] . ',';
                                                                }
                                                              } ?>">
                        <?php foreach ($tags as $tag) {
                              if ($tag['name']) {
                                echo $tag['name'] . ',';
                              }
                            } ?>
                      </td>
                      <td><?php echo $row['date']; ?></td>
                      <td>
                        <?php
                            $check = checkPer($user['id'], 'post_edit');
                            if ($check === TRUE) :
                              echo "<a class='btn btn-success editNewsBtn ' href=../news/editNews.php?id=" . $row['id'] .  ">Edit</a>";
                            ?>

                        <?php
                            endif;
                            $check = checkPer($user['id'], 'post_delete');
                            if ($check === TRUE) :
                            ?>
                        <button type="button" class="btn btn-danger deleteNewsBtn">Delete</button>
                      </td>
                      <?php
                            endif;
                        ?>
                    </tr>
                    <?php
                      }
                    } else {
                      echo "0 results";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
      <?php include '../../partial/footer.php' ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="../../../../public/core/assets/js/scripts.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="../../../../public/core/assets/js/datatables-demo.js"></script>
  <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>