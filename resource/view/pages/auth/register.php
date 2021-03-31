<?php
include '../../../../database/database.php';
include '../../../../function/function.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../../vendor/PHPMailer-master/src/Exception.php';
require '../../../../vendor/PHPMailer-master/src/PHPMailer.php';
require '../../../../vendor/PHPMailer-master/src/SMTP.php';

function sendEmail($email, $name, $title, $content)
{
  $mail = new PHPMailer(true);
  try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nguyenduyhung9396@gmail.com';
    $mail->Password = 'hylpjbajejhgqrio';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('nguyenduyhung9396@gmail.com', 'Web Admin');

    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $content;
    $mail->CharSet = 'UTF-8';
    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}







$firstnameError = $lastnameError = $emailError = $passwordError = $confirmError = $textError = "";
$firstname = $lastname = $email = $password = $confirm = "";
if (isset($_POST["register"])) {
  $firstname = test_input($_POST["firstname"]);
  $lastname = test_input($_POST["lastname"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $confirm = test_input($_POST["confirm"]);
  if ($firstname === "" || $lastname === "" || $email === "" || $password === "" || $confirm === "") {
    $textError = "Please enter information";
  } else {
    $sql = "SELECT * FROM users WHERE email = '$email' ";
    $check = mysqli_query($conn, $sql);
    if (mysqli_num_rows($check) > 0) {
      $emailError = "Account already exists";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Email is not a valid";
    } else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[0-9a-zA-Z\d]{8,}$/", $password)) {
      $passwordError = "Mật khẩu phải có 8 kí tự và chạy từ a-z, A-Z, 0-9";
    } else {
      if ($password === $confirm) {
        $password = md5($password);
        $time = date('Y-m-d H:i:s');
        $sql = "INSERT INTO users (firstname, lastname, email, password, created_at, role_id) VALUES ('$firstname', '$lastname', '$email', '$password', '$time', 3)";
        if ($conn->query($sql) === TRUE) {
          $content = 'Chúc mừng bạn đã đăng ký tài khoản thành công<br>
                Tài khoản của bạn là :<br>
                username: ' . $email . '<br>' .
            'password: ' . $password . '<br>' .
            'Click vào đây để kích hoạt tài khoản <a href="http://' . $_SERVER['HTTP_HOST'] . '/dbAdmin/resource/view/pages/auth/activeAccount.php?email=' . $email . '&time=' . $time . '">Kích hoạt tài khoản</a>';

          //  Gửi email thông báo tạo tài khoảng thành công
          sendEmail($email, $firstname, 'Đăng ký tài khoản thành công!', $content);
          echo '<script language="javascript">alert("Đăng ký thành công"); window.location="login.php";</script>';
        } else {
          echo "Error Insert: " . $sql . "<br>" . $conn->error;
        }
      } else {
        $passwordError = "Password Error";
      }
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
  <title>Page Title - SB Admin</title>
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
            <div class="col-lg-7">
              <div class="card shadow-lg border-0 rounded-lg my-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">Create Account</h3>
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="small mb-1" for="inputFirstName">First Name</label>
                          <input name="firstname" value="<?php echo $firstname ?>" class="form-control py-4"
                            id="inputFirstName" type="text" placeholder="Enter first name" />
                          <span class="error"><?php echo $textError; ?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="small mb-1" for="inputLastName">Last Name</label>
                          <input name="lastname" value="<?php echo $lastname ?>" class="form-control py-4"
                            id="inputLastName" type="text" placeholder="Enter last name" />
                          <span class="error"><?php echo $textError; ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="small mb-1" for="inputEmailAddress">Email</label>
                      <input name="email" value="<?php echo $email ?>" class="form-control py-4" id="inputEmailAddress"
                        type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                      <span class="error"><?php echo $textError; ?></span>
                      <span class="error"><?php echo $emailError; ?></span>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="small mb-1" for="inputPassword">Password</label>
                          <input name="password" class="form-control py-4" id="inputPassword" type="password"
                            placeholder="Enter password" />
                          <span class="error"><?php echo $textError; ?></span>
                          <span class="error"><?php echo $passwordError; ?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                          <input name="confirm" class="form-control py-4" id="inputConfirmPassword" type="password"
                            placeholder="Confirm password" />
                          <span class="error"><?php echo $textError; ?></span>
                          <span class="error"><?php echo $passwordError; ?></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mt-4 mb-0">
                      <button name="register" class="btn btn-primary btn-block">Create Account</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center">
                  <div class="small"><a href="login.php">Have an account? Go to login</a></div>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>
  <script src="../../../../public/core/assets/js/scripts.js"></script>
  <script src="../../../../public/admin/assets/js/main.js"></script>
</body>

</html>