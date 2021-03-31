<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['user'])) {
  header('Location: ../main/login.php');
}

include '../../../../database/database.php';
include '../../../../function/function.php';
$sql = "SELECT * FROM employees";

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
  <title>Manage Employees - Dashboard Admin</title>
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">
</head>

<body class="sb-nav-fixed">
  <!-- ///========= Add Modal =========/// -->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../action/add.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Add</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group position-relative text-center">
              <img class="form__img" src="../../../../public/admin/assets/images/upload/default.png" width="100">
              <label for="fileImages" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileImages" id="fileImages">
              </label>
            </div>
            <div class="form-group">
              <label for="name_add">Name:</label>
              <input type="text" name="name_add" id="name_add" class="form-control">
            </div>
            <div class="form-group">
              <label for="position_add">Position:</label>
              <input type="text" name="position_add" id="position_add" class="form-control">
            </div>
            <div class="form-group">
              <label for="office_add">Office:</label>
              <input type="text" name="office_add" id="office_add" class="form-control">
            </div>
            <div class="form-group">
              <label for="age_add">Age:</label>
              <input type="number" name="age_add" id="age_add" class="form-control">
            </div>
            <div class="form-group">
              <label for="startDate_add">Start Date:</label>
              <input type="date" name="startDate_add" id="startDate_add" class="form-control">
            </div>
            <div class="form-group">
              <label for="salary_add">Salary($):</label>
              <input type="number" name="salary_add" id="salary_add" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="add" class="btn btn-primary">Add</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Edit Modal =========/// -->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../action/edit.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Edit</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_upd" name="id_upd">
            <div class="form-group position-relative text-center">
              <img class="form__img" width="100" id="updateImg">
              <label for="fileImages" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileImages" id="fileImages">
              </label>
            </div>
            <div class="form-group">
              <label for="name_upd">Name:</label>
              <input type="text" name="name_upd" id="name_upd" class="form-control">
            </div>
            <div class="form-group">
              <label for="position_upd">Position:</label>
              <input type="text" name="position_upd" id="position_upd" class="form-control">
            </div>
            <div class="form-group">
              <label for="office_upd">Office:</label>
              <input type="text" name="office_upd" id="office_upd" class="form-control">
            </div>
            <div class="form-group">
              <label for="age_upd">Age:</label>
              <input type="number" name="age_upd" id="age_upd" class="form-control">
            </div>
            <div class="form-group">
              <label for="startDate_upd">Start Date:</label>
              <input type="date" name="startDate_upd" id="startDate_upd" class="form-control">
            </div>
            <div class="form-group">
              <label for="salary_upd">Salary($):</label>
              <input type="number" name="salary_upd" id="salary_upd" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update" class="btn btn-success">Sửa</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Delete Modal =========/// -->
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../action/delete.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Delete</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Are you sure?</h5>
            <input type="hidden" id="id_del" name="id_del">
            <div class="form-group">
              <input type="hidden" name="fileImages" id="fileImages">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include '../../partial/header.php'; ?>
  <div id="layoutSidenav">
    <?php include '../../partial/sidenav.php' ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Manage Employees</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Manage Employees</li>
          </ol>
          <button data-toggle="modal" data-target="#addModal" class="btn btn-primary addBtn mb-2">New Employees</button>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              Employees Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th style="display: none;">Start Date</th>
                      <th>Start Date</th>
                      <th style="display: none;">Salary</th>
                      <th>Salary</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th style="display: none;">Start Date</th>
                      <th>Start Date</th>
                      <th style="display: none;">Salary</th>
                      <th>Salary</th>
                      <th>Status</th>
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
                      <td class="imgBtn text-center"><img src="<?php if ($row['images']) {
                                                                      echo $row['images'];
                                                                    } else {
                                                                      echo '../../../../public/admin/assets/images/upload/default.png';
                                                                    } ?>" width="100" alt=""></td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['position']; ?></td>
                      <td><?php echo $row['office']; ?></td>
                      <td><?php echo $row['age']; ?></td>
                      <td style="display: none;"><?php echo $row['startDate']; ?></td>
                      <td><?php $date = date("d-m-Y", strtotime($row['startDate']));
                              echo $date; ?></td>
                      <td style="display: none;"><?php echo $row['salary']; ?></td>
                      <td><?php echo number_format($row['salary'], 0); ?></td>
                      <?php
                          $status = $row['status'];
                          if ($status == 0) {
                            $strStatus = "<a class='btn btn-secondary' href=../action/activate.php?id=" . $row['id'] . ">Deactivate</a>";
                          }
                          if ($status == 1) {
                            $strStatus = "<a class='btn btn-warning text-white' href=../action/deactivate.php?id=" . $row['id'] . ">Active</a>";
                          }
                          ?>
                      <td><?php echo $strStatus ?></td>
                      <td>
                        <button type="button" class="btn btn-success editBtn">Edit</button>
                        <button type="button" class="btn btn-danger deleteBtn">Delete</button>
                      </td>
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
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>