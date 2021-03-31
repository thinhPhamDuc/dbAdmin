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

$id = $_GET['id'];
$sql = "SELECT * FROM news WHERE id = '$id' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql = "SELECT * FROM news_categories ORDER BY id DESC";
$categories = $conn->query($sql);

$sql = "SELECT * FROM news_tag ORDER BY name ASC";
$tags = $conn->query($sql);

if (isset($_POST['editNews'])) {
  $title = test_input($_POST["title_editNews"]);
  $description = test_input($_POST["description_editNews"]);
  $content = mysqli_real_escape_string($conn, $_POST["content_editNews"]);
  $author = test_input($_POST["author_editNews"]);
  $category = test_input($_POST["category_editNews"]);
  $file_store = editImages("../../../../../dbadmin/public/admin/assets/images/news/", '../main/news.php', 'news', $id);
  if ($title === "" || $description === "" || $content === "" || $category === "") {
    echo "<script>alert('Không được để rỗng!'); window.location = '../news/editNews.php';</script>";
  } else {
    $update = "UPDATE news SET title='$title', description ='$description', content='$content', author = '$author', category_id = '$category', images ='$file_store' WHERE id='$id'";

    if ($conn->query($update) === true) {
      //  Gắn tags cho sản phẩm
      $tags = $_POST["tags"];
      if (!empty($tags)) {
        //  Lấy tag đã chọn
        $sql = "SELECT * FROM `link_news_tag` WHERE news_id = " . $id;
        $result = $conn->query($sql);
        $tag_da_chon = [];
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $tag_da_chon[$row['tag_id']] = $row['tag_id'];
          }
        }
        foreach ($tags as $tag_id) {
          //  Kiểm tra nếu có rồi thì bỏ qua
          $sql = "SELECT * FROM `link_news_tag` WHERE news_id = " . $id . " AND tag_id = " . $tag_id;

          $result = $conn->query($sql);
          if ($result->num_rows == 0) {
            //  Inert thêm vào nếu chưa có
            $sql = "INSERT INTO link_news_tag (news_id, tag_id) VALUES ('$id', '$tag_id')";
            $conn->query($sql);
          }
          unset($tag_da_chon[$tag_id]);
        }
        //  Loại bỏ tag thừa
        if (!empty($tag_da_chon)) {
          $sql = "DELETE FROM link_news_tag WHERE news_id = " . $id . " AND tag_id in (";

          $arr = [];
          foreach ($tag_da_chon as $v) {
            $arr[] = $v;
          }
          foreach ($arr as $k => $tag_id) {
            if ($k == 0) {
              $sql .= $tag_id;
            } else {
              $sql .= ',' . $tag_id;
            }
          }
          $sql .= ')';
          $conn->query($sql);
        }
      } else {
        //  trường hợp mà không chọn tag nào thì xóa hết các liên kết product_tag
        $sql = "DELETE FROM link_news_tag WHERE news_id = " . $id;
        $conn->query($sql);
      }
      echo "<script>window.location = '../main/news.php';</script>";
    } else {
      echo "<script>alert('Error!'); window.location = '../news/editNews.php';</script>";
    }
  }
}







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
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="../main/index.php">
      <?php
      $id = $_SESSION["user"]["id"];
      $query = mysqli_query($conn, "SELECT * FROM users where id='$id'");
      $user = $query->fetch_assoc();
      echo "Xin chào " . $user['firstname'];
      ?>
    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input class="form-control" type="text" placeholder="Tìm kiếm..." aria-label="Search"
          aria-describedby="basic-addon2" />
        <div class="input-group-append">
          <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img style="border-radius: 50%;" src="
              <?php if ($user['images']) {
                echo $user['images'];
              } else {
                echo '../../../../public/admin/assets/images/user/defaultImage.jpg';
              }
              ?>" alt="avatar" width="30" height="30">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="../main/profile.php">Thông tin cá nhân</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../../auth/logout.php">Đăng xuất</a>
        </div>
      </li>
    </ul>
  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="../main/index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Interface</div>
            <?php
            $check = checkPer($user['id'], 'user_view');
            if ($check === TRUE) :
            ?>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManage"
              aria-expanded="false" aria-controls="collapseManage">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              Manage
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseManage" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="../main/manage-employees.php">Manage Employees</a>
                <a class="nav-link" href="../main/users.php">Manage Users</a>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <?php
            $check = checkPer($user['id'], 'product_view');
            if ($check === TRUE) :
            ?>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts"
              aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-store"></i></div>
              Products
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="../main/product.php">Product</a>
                <a class="nav-link" href="../main/productCategory.php">Product Category</a>
                <a class="nav-link" href="../main/productTag.php">Product Tag</a>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <?php
            $check = checkPer($user['id'], 'post_view');
            if ($check === TRUE) :
            ?>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
              aria-expanded="false" aria-controls="collapseCategory">
              <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
              News
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCategory" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="../main/news.php">News</a>
                <a class="nav-link" href="../main/newsCategory.php">News Category</a>
                <a class="nav-link" href="../main/newsTag.php">News Tag</a>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <?php
            $check = checkPer($user['id'], 'post_view');
            if ($check === TRUE) :
            ?>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
              aria-expanded="false" aria-controls="collapsePages">
              <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
              Pages
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth"
                  aria-expanded="false" aria-controls="pagesCollapseAuth">
                  Authentication
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                  data-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="../auth/login.php">Login</a>
                    <a class="nav-link" href="../auth/register.php">Register</a>
                    <a class="nav-link" href="../auth/forgotPassword.php">Forgot Password</a>
                  </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError"
                  aria-expanded="false" aria-controls="pagesCollapseError">
                  Error
                  <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                  data-parent="#sidenavAccordionPages">
                  <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="../error/401.php">401 Page</a>
                    <a class="nav-link" href="../error/404.php">404 Page</a>
                    <a class="nav-link" href="../error/500.php">500 Page</a>
                  </nav>
                </div>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <?php
            $check = checkPer($user['id'], 'role_view');
            if ($check === TRUE) :
            ?>
            <div class="sb-sidenav-menu-heading">Admin</div>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRole"
              aria-expanded="false" aria-controls="collapseRole">
              <div class="sb-nav-link-icon"><i class="fas fa-globe-europe"></i></div>
              Role
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseRole" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="../main/roles.php">Manage Role</a>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="../main/charts.php">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Charts
            </a>
            <a class="nav-link" href="../main/tables.php">
              <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
              Tables
            </a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          <?php
          echo $user["email"];
          ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Edit News</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit News</li>
          </ol>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              Edit News
            </div>
            <div class="card-body">
              <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id_editNews" name="id_editNews">
                <div class="form-group position-relative text-center">
                  <img class="form__img" id="img_editNews" src="<?php if ($row['images']) {
                                                                  echo $row['images'];
                                                                } else {
                                                                  echo '../../../../public/admin/assets/images/news/default.png';
                                                                } ?>" width="100" alt="">
                  <label for="fileImages" class="form__label">
                    <i class="fal fa-pen"></i>
                    <input type="file" name="fileImages" id="fileImages">
                  </label>
                </div>
                <div class="form-group">
                  <label for="title_editNews">Title:</label>
                  <input type="text" value="<?php echo $row['title']; ?>" name="title_editNews" id="title_editNews"
                    class="form-control">
                </div>
                <div class="form-group">
                  <label for="description_editNews">Description:</label>
                  <input type="text" value="<?php echo $row['description']; ?>" name="description_editNews"
                    id="description_editNews" class="form-control">
                </div>
                <div class="form-group">
                  <label for="content_editNews">Content:</label>
                  <textarea type="text" name="content_editNews" id="content_editNews"
                    class="form-control"><?php echo $row['content']; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="author_editNews">Author:</label>
                  <input type="text" value="<?php echo $row['author']; ?>" name="author_editNews" id="author_editNews"
                    class="form-control">
                </div>
                <div class="form-group">
                  <label for="category_editNews">Categories:</label>
                  <input id="category_editNewsVal" type="hidden" value="<?php echo $row['category_id']; ?>">
                  <select name="category_editNews" id="category_editNews" class="form-control">
                    <?php
                    echo newsCategoryTree();
                    ?>
                  </select>
                </div>
                <div class="form-group form-tag">
                  <p id="newsTags" style="display: none;">
                    <?php
                    $newsTags = getNewsTags($row['id']);
                    foreach ($newsTags as $tag) {
                      if ($tag['id']) {
                        echo $tag['id'] . ',';
                      }
                    }
                    ?>
                  </p>
                  <label for="newsTagUpdate">Tag:</label>
                  <?php
                  $list_tags = [];
                  if ($tags->num_rows > 0) {
                    while ($row = $tags->fetch_assoc()) {
                      $list_tags[] = $row;
                    }
                  }
                  foreach ($list_tags as $item) {
                    echo '<label style="display: inline-block; width: 100%;"><input style="margin-right: 5px" name="tags[]" class="tag-' . $item['id'] . '" type="checkbox" value="' . $item['id'] . '">' . $item['name'] . '</label>';
                  }
                  ?>
                </div>
                <button type="submit" name="editNews" class="btn btn-success">Edit</button>
              </form>
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