<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">
    <?php
    $id = $_SESSION["user"]["id"];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id' ");
    $user = $query->fetch_assoc();
    echo "Welcome " . $user['firstname'];
    ?>
  </a>
  <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
      class="fas fa-bars"></i></button>
  <!-- Navbar Search-->
  <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    <div class="input-group">
      <input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
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
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="#">Settings</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="../auth/logout.php">Logout</a>
      </div>
    </li>
  </ul>
</nav>