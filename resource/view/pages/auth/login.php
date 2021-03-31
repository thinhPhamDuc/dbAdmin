<?php
session_start();

if (isset($_SESSION['user'])) {
  header('Location: ../main/index.php');
}

if (isset($_POST['login'])) {
  include '../../../../database/database.php';
  include '../../../../function/function.php';
  $email = ($_POST['email']);
  $password = md5($_POST['password']);
  $sql = "SELECT * FROM users WHERE email = '$email' && password = '$password' && active = 1 ";
  $query = mysqli_query($conn, $sql);
  if (mysqli_num_rows($query) > 0) {
    $user = $query->fetch_assoc();

    $_SESSION['user'] = [
      'id' => $user['id'],
      'email' => $user['email']
    ];
    if (isset($_POST['remember_me'])) {
      setcookie('email', $email, time() + (3600 * 24 * 30));
      setcookie('password', $_POST["password"], time() + (3600 * 24 * 30));
    }
    header('Location: ../main/index.php');
  } else {
    echo '<script>alert("Invalid Email ID/Password");</script>';
  }
} else {
  $email = '';
  $password = '';
  if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
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
  <title>Login - Dashboard Admin</title>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
  <link rel="stylesheet" href="../../../../public/core/assets/css/styles.css">
  <link rel="stylesheet" href="../../../../public/admin/assets/css/main.css">

</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-group">
                      <label class="small mb-1" for="inputEmailAddress">Email</label>
                      <input name="email" value="<?php echo $email; ?>" class="form-control py-4" id="inputEmailAddress"
                        type="email" placeholder="Enter email address" />
                    </div>
                    <div class="form-group">
                      <label class="small mb-1" for="inputPassword">Password</label>
                      <input name="password" value="<?php echo $password; ?>" class="form-control py-4"
                        id="inputPassword" type="password" placeholder="Enter password" />
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input name="remember_me" class="custom-control-input" id="rememberPasswordCheck"
                          type="checkbox" />
                        <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                      </div>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                      <a class="small" href="forgotPassword.php">Forgot Password?</a>
                      <button name="login" class="btn btn-primary">Login</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center">
                  <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div id="layoutAuthentication_footer">
      <?php include '../../partial/footer.php' ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="../../../../public/core/assets/js/scripts.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>