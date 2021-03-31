    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="index.php">
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
                <a class="nav-link" href="manage-employees.php">Manage Employees</a>
                <a class="nav-link" href="users.php">Manage Users</a>
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
                <a class="nav-link" href="product.php">Product</a>
                <a class="nav-link" href="productCategory.php">Product Category</a>
                <a class="nav-link" href="productTag.php">Product Tag</a>
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
                <a class="nav-link" href="news.php">News</a>
                <a class="nav-link" href="newsCategory.php">News Category</a>
                <a class="nav-link" href="newsTag.php">News Tag</a>
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
                <a class="nav-link" href="roles.php">Manage Role</a>
              </nav>
            </div>
            <?php
            endif;
            ?>
            <div class="sb-sidenav-menu-heading">Addons</div>
            <a class="nav-link" href="charts.php">
              <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
              Charts
            </a>
            <a class="nav-link" href="tables.php">
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