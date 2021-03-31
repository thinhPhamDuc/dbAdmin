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
if (!checkPer($user['id'], 'product_view')) {
  header('Location:../error/404.php');
}

$sql = "SELECT * FROM products";

$result = $conn->query($sql);

$sql = "SELECT * FROM product_categories ORDER BY id DESC";
$categories = $conn->query($sql);

$sql = "SELECT * FROM product_tag ORDER BY name ASC";
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
  <div class="modal fade" id="addProduct">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product/addProduct.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Add Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group position-relative text-center">
              <img class="form__img" src="../../../../public/admin/assets/images/product/default.png" width="100">
              <label for="fileProduct" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileProduct" id="fileProduct">
              </label>
            </div>
            <div class="form-group">
              <label for="name_addProduct">Name:</label>
              <input type="text" name="name_addProduct" id="name_addProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="description_addProduct">Description:</label>
              <input type="text" name="description_addProduct" id="description_addProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="price_addProduct">Price:</label>
              <input type="number" name="price_addProduct" id="price_addProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="category_addProduct">Categories:</label>
              <select name="category_addProduct" id="category_addProduct" class="form-control">
                <?php
                echo productCategoryTree();
                ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tags_addProduct">Tags:</label>
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
            <button type="submit" name="addProduct" class="btn btn-primary">Add</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Edit Modal =========/// -->
  <div class="modal fade" id="editProduct">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product/editProduct.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Edit Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_editProduct" name="id_editProduct">
            <div class="form-group position-relative text-center">
              <img class="form__img" width="100" id="img_editProduct">
              <label for="fileProduct" class="form__label">
                <i class="fal fa-pen"></i>
                <input type="file" name="fileProduct" id="fileProduct">
              </label>
            </div>
            <div class="form-group">
              <label for="name_editProduct">Name:</label>
              <input type="text" name="name_editProduct" id="name_editProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="description_editProduct">Description:</label>
              <input type="text" name="description_editProduct" id="description_editProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="price_editProduct">Price:</label>
              <input type="number" name="price_editProduct" id="price_editProduct" class="form-control">
            </div>
            <div class="form-group">
              <label for="category_editProduct">Categories:</label>
              <select name="category_editProduct" id="category_editProduct" class="form-control">
                <?php
                echo productCategoryTree();
                ?>
              </select>
            </div>
            <div class="form-group form-tag">
              <label for="tags_editProduct">Tags:</label>
              <?php
              foreach ($list_tags as $item) {
                echo '<label style="display: block;"><input style="margin-right: 5px;" name="tags[]" class="tag-' . $item['id'] . '" type="checkbox" value="' . $item['id'] . '">' . $item['name'] . '</label>';
              }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="editProduct" class="btn btn-success">Edit</button>
            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- ///========= Delete Modal =========/// -->
  <div class="modal fade" id="deleteProduct">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../product/deleteProduct.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h4 class="modal-title">Delete Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <h5>Are you sure?</h5>
            <input type="hidden" id="id_deleteProduct" name="id_deleteProduct">
            <div class="form-group">
              <input type="hidden" name="fileProduct" id="fileProduct">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="deleteProduct" class="btn btn-danger">Delete</button>
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
          <h1 class="mt-4">Product</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Product</li>
          </ol>
          <?php
          $check = checkPer($user['id'], 'product_add');
          if ($check === TRUE) :
          ?>
          <button data-toggle="modal" data-target="#addProduct" class="btn btn-primary addProductBtn mb-2">New
            Product</button>
          <?php
          endif;
          ?>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table mr-1"></i>
              Product Table
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Tags</th>
                      <th style="display: none;">Price</th>
                      <th>Price</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th style="display: none;">ID</th>
                      <th>Images</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>Tags</th>
                      <th style="display: none;">Price</th>
                      <th>Price</th>
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
                      <td class="imgProductBtn text-center"><img src="<?php if ($row['images']) {
                                                                            echo $row['images'];
                                                                          } else {
                                                                            echo '../../../../public/admin/assets/images/product/default.png';
                                                                          } ?>" width="100" alt="">
                      </td>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['description']; ?></td>
                      <?php
                          $cate = getProductCategory($row['category_id']);
                          ?>
                      <td class="field-category" data-category_id="<?php if ($cate['id']) echo $cate['id'] ?>">
                        <?php if ($cate['name']) echo $cate['name'] ?></td>
                      <?php
                          $tags = getProductTags($row['id']);
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
                      <td style="display: none;"><?php echo $row['price']; ?></td>
                      <td><?php echo number_format($row['price'], 0); ?></td>
                      <?php
                          $status = $row['status'];
                          if ($status == 0) {
                            $strStatus = "<a class='btn btn-secondary' href=../product/activateProduct.php?id=" . $row['id'] . ">Deactivate</a>";
                          }
                          if ($status == 1) {
                            $strStatus = "<a class='btn btn-warning text-white' href=../product/deactivateProduct.php?id=" . $row['id'] . ">Active</a>";
                          }
                          ?>
                      <td><?php echo $strStatus ?></td>
                      <td>
                        <?php
                            $check = checkPer($user['id'], 'product_edit');
                            if ($check === TRUE) :
                            ?>
                        <button type="button" class="btn btn-success editProductBtn">Edit</button>
                        <?php
                            endif;
                            $check = checkPer($user['id'], 'product_delete');
                            if ($check === TRUE) :
                            ?>
                        <button type="button" class="btn btn-danger deleteProductBtn">Delete</button>
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
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>