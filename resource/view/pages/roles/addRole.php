<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user'])) {
  header('Location:../auth/login.php');
}

include '../../../../database/database.php';
include '../../../../function/function.php';
$query = mysqli_query($conn, "SELECT * FROM roles");
$role = $query->fetch_assoc();

$sql = "SELECT * FROM `permissions` ORDER BY code ASC";
$permissions = $conn->query($sql);

if ($_POST) {
  $name = test_input($_POST["name_addRole"]);
  if ($name === "") {
    echo "<script>alert('Không được để rỗng!'); window.location = '../main/roles.php';</script>";
  } else {
    $add = "INSERT INTO roles (name) VALUES ('$name')";
    $conn->query($add);
    $query = mysqli_query($conn, "SELECT * FROM roles ORDER BY id DESC");
    $new_role = $query->fetch_assoc();
    foreach ($_POST['pers'] as $per_id) {
      //  Gán các quyền mới chọn vào nhóm quyền
      $sql = "INSERT INTO `link_role_permission` (role_id, permission_id) VALUES ( $new_role[id]  , $per_id)";
      $conn->query($sql);
    }
  }
  echo "<script>window.location = '../main/roles.php';</script>";
}
$sql = "SELECT * FROM `link_role_permission` WHERE role_id = $role[id]";
$permissions_checked = $conn->query($sql);
$pers_checked = [];
if ($permissions->num_rows > 0) {
  while ($row = $permissions_checked->fetch_assoc()) {
    $pers_checked[] = $row['permission_id'];
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
  <title>Add Role</title>
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
          <a class="dropdown-item" href="profile.php">Thông tin cá nhân</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../auth/logout.php">Đăng xuất</a>
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
    <div id="layoutSidenav_content" style="background: #f2f3f8">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Thêm quyền</h1>
          <ol class="breadcrumb mb-4" style="background: white">
            <li class="breadcrumb-item"><a href="../index/index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Thêm quyền</li>
          </ol>
          <form action="" method="POST">
            <div class="role__content row">
              <div class="col-md-4">
                <div class="role__left">
                  <div class="form-group">
                    <label for="name_addRole">Tên quyền:</label>
                    <input type="text" name="name_addRole" class="form-control" id="name_addRole">
                  </div>
                  <button type="submit" class="btn btn-primary addRoleBtn">Lưu
                  </button>
                </div>
              </div>
              <div class="col-md-8">
                <div class="role__right">
                  <?php
                  $code = '';
                  if ($permissions->num_rows > 0) {
                    while ($row = $permissions->fetch_assoc()) {
                      $module_name = @explode('_', $row['code'])[0];
                      if ($module_name != $code) {
                        $code = $module_name;
                        if ($module_name === "post") {
                          $module_name = "Bài viết";
                        } elseif ($module_name === "product") {
                          $module_name = "Sản phẩm";
                        } elseif ($module_name === "role") {
                          $module_name = "Quyền";
                        } elseif ($module_name === "user") {
                          $module_name = "Người dùng";
                        }
                  ?>
                  <label class='perChecked' style="margin-top: 30px">
                    <input style='margin-right: 5px;' name='inputPers' type='checkbox' checked
                      value="<?php echo $row['id']; ?>"><?php echo $module_name; ?>
                  </label>
                  <?php
                      }
                      ?><label style="display: inline-block; width: 100%; margin-left: 20px">
                    <input style="margin-right: 5px;" name="pers[]" type="checkbox" checked
                      value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                  </label>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          </form>
        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Bản quyền &copy; Website của bạn 2020</div>
            <div>
              <a href="#">Chính sách Bảo mật</a>
              &middot;
              <a href="#">Điều khoản & Điều kiện</a>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>

  <script src="../../../../public/admin/assets/js/scripts.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="../../../../public/core/assets/js/datatables-demo.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>