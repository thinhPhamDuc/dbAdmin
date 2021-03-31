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
  <title>Charts - SB Admin</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">

</head>

<body class="sb-nav-fixed">
  <?php include '../../partial/header.php'; ?>
  <div id="layoutSidenav">
    <?php include '../../partial/sidenav.php'; ?>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid">
          <h1 class="mt-4">Charts</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Charts</li>
          </ol>
          <div class="card mb-4">
            <div class="card-body">
              Chart.js is a third party plugin that is used to generate the charts in this template. The charts below
              have been customized - for further customization options, please visit the official
              <a target="_blank" href="https://www.chartjs.org/docs/latest/">Chart.js documentation</a>
              .
            </div>
          </div>
          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-chart-area mr-1"></i>
              Area Chart Example
            </div>
            <div class="card-body"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-bar mr-1"></i>
                  Bar Chart Example
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Pie Chart Example
                </div>
                <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <?php include '../../partial/footer.php'; ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="../../../../public/core/assets/js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="../../../../public/core/assets/js/chart-area-demo.js"></script>
  <script src="../../../../public/core/assets/js/chart-bar-demo.js"></script>
  <script src="../../../../public/core/assets/js/chart-pie-demo.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>