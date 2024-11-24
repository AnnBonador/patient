<aside class="main-sidebar sidebar-dark-primary elevation-3">

  <a href="../../../index.php" class="brand-link">
    <img src="../../../upload/<?= $system_logo ?>" alt="image" class="brand-image img-circle elevation-3">
    <span class="brand-text font-weight-normal text-lg text-light"><?= $system_name ?></span>
  </a>
  <?php $page = basename(dirname($_SERVER['PHP_SELF'])); ?>
  <div class="sidebar">
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="../dashboard" class="nav-link <?= $page == 'dashboard' ? 'active' : '' ?>">
            <i class="fa fa-home nav-icon"></i>
            <p>Dashboard </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../admins" class="nav-link <?= $page == 'admins' ? 'active' : '' ?>">
            <i class="fas fa-user-shield nav-icon"></i>
            <p>Admins </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../dentists" class="nav-link <?= $page == 'dentists' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-md"></i>
            <p>Dentists</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../staffs" class="nav-link <?= $page == 'staffs' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-nurse"></i>
            <p>Staffs</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../patients" class="nav-link <?= $page == 'patients' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Patients</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../schedules" class="nav-link <?= $page == 'schedules' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-clock"></i>
            <p>Schedules</p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'appointments' || $page == 'calendar' || $page == 'online-appointments' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'appointments' || $page == 'calendar' || $page == 'online-appointments' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-calendar"></i>
            <p>
              Appointment List
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../appointments" class="nav-link <?= $page == 'appointments' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Walk In Request</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../online-appointments" class="nav-link <?= $page == 'online-appointments' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Online Request</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../calendar" class="nav-link <?= $page == 'calendar' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Calendar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../payments" class="nav-link <?= $page == 'payments' ? 'active' : '' ?>">
            <i class="nav-icon fab fa-cc-paypal"></i>
            <p>Payments</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../prescriptions" class="nav-link <?= $page == 'prescriptions' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-prescription"></i>
            <p>Prescriptions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="../treated" class="nav-link <?= $page == 'treated'  ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-check"></i>
            <p>Treated</p>
          </a>
        </li>
        <li class="nav-item <?= $page == 'highlight' || $page == 'about' || $page == 'services' || $page == 'mail' || $page == 'procedure-offers' || $page == 'sms' || $page == 'payment-settings' || $page == 'health-declaration' || $page == 'reviews' || $page == 'gallery' || $page == 'featured' || $page == 'system' ? 'menu-open' : '' ?>">
          <a href="#" class="nav-link <?= $page == 'highlight' || $page == 'about' || $page == 'services' || $page == 'mail' || $page == 'procedure-offers' || $page == 'sms' || $page ==  'payment-settings' || $page == 'health-declaration' || $page == 'reviews' || $page == 'gallery' || $page == 'featured' || $page == 'system' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>Website</p>
            <i class="fas fa-angle-left right "></i>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../highlight" class="nav-link <?= $page == 'highlight' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Highlight Content</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../about" class="nav-link <?= $page == 'about' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>About Us</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../services" class="nav-link <?= $page == 'services' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Services</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../procedure-offers" class="nav-link <?= $page == 'procedure-offers' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Procedure Offers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../health-declaration" class="nav-link <?= $page == 'health-declaration' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Questionnaire</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../reviews" class="nav-link <?= $page == 'reviews' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Review</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../gallery" class="nav-link <?= $page == 'gallery' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Gallery</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../featured" class="nav-link <?= $page == 'featured' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Featured Dentist</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../mail" class="nav-link <?= $page == 'mail' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Email Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../payment-settings" class="nav-link <?= $page == 'payment-settings' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Payment Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../system" class="nav-link <?= $page == 'system' ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Website Settings</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="../reports" class="nav-link <?= $page == 'reports' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-file-pdf "></i>
            <p>Reports</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>