<body>
  <?php $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1); ?>
  <div id="topbar" class="d-flex align-items-center fixed-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:<?= $email ?>"><?= $email ?></a>
        <i class="bi bi-phone"></i><?= $mobile ?>
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <a href="<?= $facebook ?>" class="facebook"><i class="bi bi-facebook"></i></a>
      </div>
    </div>
  </div>

  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <a href="index.php" class="logo me-auto"><img src="upload/<?= $brand ?>" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto <?= $page == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto <?= $page == 'about-us.php' ? 'active' : '' ?>" href="about-us.php">About</a></li>
          <li class="dropdown"><a class="nav-link scrollto <?= $page == 'our-services.php' ? 'active' : '' ?>" href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <?php
              $sql = "SELECT * FROM services";
              $query_run = mysqli_query($conn, $sql);
              $check_services = mysqli_num_rows($query_run) > 0;

              if ($check_services) {
                while ($row = mysqli_fetch_array($query_run)) { ?>
                  <li><a href="our-services.php?title=<?= $row['title'] ?>"><?= $row['title'] ?></a></li>
              <?php }
              } ?>
            </ul>
          </li>
          <?php
          session_start();
          if (isset($_SESSION['auth'])) {
            if ($_SESSION['auth_role'] == "patient") {
          ?>
              <li><a class="nav-link scrollto <?= $page == 'patient/request-appointment.php' ? 'active' : '' ?>" href="patient/request-appointment.php">Make an Appointment</a></li>
            <?php
            }
          } else {
            ?>
            <li><a class="nav-link scrollto <?= $page == 'patient/request-appointment.php' ? 'active' : '' ?>" href="patient/request-appointment.php">Make an Appointment</a></li>
          <?php
          }

          ?>

          <li><a class="nav-link scrollto <?= $page == 'dental-services-rates.php' ? 'active' : '' ?>" href="dental-services-rates.php">Fees</a></li>
          <li><a class="nav-link scrollto <?= $page == 'contact-us.php' ? 'active' : '' ?>" href="contact-us.php">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <a href="login.php" class="appointment-btn"><span class="d-none d-md-inline"></span>Login</a>


    </div>
  </header>