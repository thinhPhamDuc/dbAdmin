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
if (!checkPer($user['id'], 'user_view')) {
  header('Location:../error/404.php');
}

$sql = "SELECT * FROM users";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Users - Dashboard Admin</title>
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">
</head>

<body class="sb-nav-fixed">
  <!-- ///========= Add Modal =========/// -->
  <div class="modal fade" id="addUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../user/addUser.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Add User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group position-relative text-center">
              <img class="form__img" src="../../../../public/admin/assets/images/user/default.png" width="100">
              <label for="fileImages" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileImages" id="fileImages">
              </label>
            </div>
            <div class="form-group">
              <label for="firstname_addUser">First Name:</label>
              <input type="text" name="firstname_addUser" id="firstname_addUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="lastname_addUser">Last Name:</label>
              <input type="text" name="lastname_addUser" id="lastname_addUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="email_addUser">Email:</label>
              <input type="email" name="email_addUser" id="email_addUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="password_addUser">Password:</label>
              <input type="password" name="password_addUser" id="password_addUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="repassword_addUser">Confirm Password:</label>
              <input type="password" name="repassword_addUser" id="repassword_addUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="role_addUser">Roles:</label>
              <?php
              $sql = "SELECT * FROM roles ORDER BY name ASC";
              $results = $conn->query($sql);
              ?>
              <select name="role_id" id="role_addUser" class="form-control">
                <option value=""></option>
                <?php
                if ($results->num_rows > 0) {
                  while ($row = $results->fetch_assoc()) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addUser" class="btn btn-primary">Add</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Edit Modal =========/// -->
  <div class="modal fade" id="editUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../user/editUser.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Edit User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_editUser" name="id_editUser">
            <div class="form-group position-relative text-center">
              <img class="form__img" width="100" id="img_editUser">
              <label for="fileImages" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileImages" id="fileImages">
              </label>
            </div>
            <div class="form-group">
              <label for="firstname_editUser">First Name:</label>
              <input type="text" name="firstname_editUser" id="firstname_editUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="lastname_editUser">Last Name:</label>
              <input type="text" name="lastname_editUser" id="lastname_editUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="email_editUser">Email:</label>
              <input type="email" name="email_editUser" id="email_editUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="password_editUser">Password:</label>
              <input type="password" name="password_editUser" id="password_editUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="repassword_editUser">Confirm Password:</label>
              <input type="password" name="repassword_editUser" id="repassword_editUser" class="form-control">
            </div>
            <div class="form-group">
              <label for="role_editUser">Roles:</label>
              <?php
              $sql = "SELECT * FROM roles ORDER BY name ASC";
              $results = $conn->query($sql);
              ?>
              <select name="role_id" id="role_editUser" class="form-control">
                <option value=""></option>
                <?php
                if ($results->num_rows > 0) {
                  while ($row = $results->fetch_assoc()) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="editUser" class="btn btn-success">Edit</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Delete Modal =========/// -->
  <div class="modal fade" id="deleteUser">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../user/deleteUser.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Delete User</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Are you sure?</h5>
            <input type="hidden" id="id_deleteUser" name="id_deleteUser">
            <div class="form-group">
              <input type="hidden" name="fileImages" id="fileImages">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="deleteUser" class="btn btn-danger">Delete</button>
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
          <h1 class="mt-4">Users</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
          <?php
          $check = checkPer($user['id'], 'user_add');
          if ($check === TRUE) :
          ?>
          <button data-toggle="modal" data-target="#addUser" class="btn btn-primary addUserBtn mb-2">New
            User</button>
          <?php
          endif;
          ?>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              Users Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Roles</th>
                      <th>Status</th>
                      <th style="display: none;">Date</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Roles</th>
                      <th>Status</th>
                      <th style="display: none;">Date</th>
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
                      <td class="imgUserBtn text-center"><img src="<?php if ($row['images']) {
                                                                          echo $row['images'];
                                                                        } else {
                                                                          echo '../../../../public/admin/assets/images/user/default.png';
                                                                        } ?>" width="100" alt="">
                      </td>
                      <td><?php echo $row['firstname']; ?></td>
                      <td><?php echo $row['lastname']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <?php
                          $role = getRole($row['role_id']);
                          ?>
                      <td class="field-role" data-role_id="<?php echo $row['role_id']; ?>"><?php echo $role['name'] ?>
                      </td>
                      <?php
                          $status = $row['status'];
                          if ($status == 0) {
                            $strStatus = "<a class='btn btn-secondary' href=../user/activateUser.php?id=" . $row['id'] . ">Deactivate</a>";
                          }
                          if ($status == 1) {
                            $strStatus = "<a class='btn btn-warning text-white' href=../user/deactivateUser.php?id=" . $row['id'] . ">Active</a>";
                          }
                          ?>
                      <td><?php echo $strStatus ?></td>
                      <td style="display: none;"><?php echo $row['created_at']; ?></td>
                      <td><?php $date = date("d-m-Y H:i:s", strtotime($row['created_at']));
                              echo $date; ?></td>
                      <td>
                        <?php
                            $check = checkPer($user['id'], 'user_edit');
                            if ($check === TRUE) :
                            ?>
                        <button type="button" class="btn btn-success editUserBtn">Edit</button>
                        <?php
                            endif;
                            $check = checkPer($user['id'], 'user_delete');
                            if ($check === TRUE) :
                            ?>
                        <button type="button" class="btn btn-danger deleteUserBtn">Delete</button>
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
  <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>