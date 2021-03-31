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
$sql = "SELECT * FROM product_tag";
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
  <title>Product - Dashboard Admin</title>
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">
</head>

<body class="sb-nav-fixed">
  <!-- ///========= Add Modal =========/// -->
  <div class="modal fade" id="addProductTag">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product tag/addProductTag.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Add Tag</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name_addProductTag">Name:</label>
              <input type="text" name="name_addProductTag" id="name_addProductTag" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addProductTag" class="btn btn-primary">Add</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Edit Modal =========/// -->
  <div class="modal fade" id="editProductTag">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product tag/editProductTag.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Edit Tag</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_editProductTag" name="id_editProductTag">
            <div class="form-group">
              <label for="name_editProductTag">Name:</label>
              <input type="text" name="name_editProductTag" id="name_editProductTag" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="editProductTag" class="btn btn-success">Edit</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Delete Modal =========/// -->
  <div class="modal fade" id="deleteProductTag">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product tag/deleteProductTag.php" method="POST">
          <div class="modal-header">
            <h4 class="modal-title">Delete Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Are you sure?</h5>
            <input type="hidden" id="id_deleteProductTag" name="id_deleteProductTag">
          </div>
          <div class="modal-footer">
            <button type="submit" name="deleteProductTag" class="btn btn-danger">Delete</button>
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
          <h1 class="mt-4">Tag</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Tag</li>
          </ol>
          <button data-toggle="modal" data-target="#addProductTag" class="btn btn-primary addProductTagBtn mb-2">New
            Tag</button>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              Tag Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Name</th>
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
                      <td><?php echo $row['name']; ?></td>
                      <td>
                        <button type="button" class="btn btn-success editProductTagBtn">Edit</button>
                        <button type="button" class="btn btn-danger deleteProductTagBtn">Delete</button>
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