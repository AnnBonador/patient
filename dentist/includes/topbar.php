

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link notification" data-toggle="dropdown" href="#">
          <i class="fas fa-bell"></i>
          <span class="badge badge-danger navbar-badge count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-notif">
          
        </div>       
      </li> 
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <span><?php
          include_once('../admin/config/dbconn.php');
          if(isset($_SESSION['auth']))
          {
            $sql = "SELECT * FROM tbldoctor WHERE id = '".$_SESSION['auth_user']['user_id']."'";
            $query_run = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_array($query_run))
            {
                echo '<img src="../upload/doctors/'.$row['image'].'" class="user-image img-circle elevation-2" alt="Doc Image">';
            ?>
          <span class="d-none d-md-inline" id="doctorName" value="<?php echo $_SESSION['auth_user']['user_id'] ?>">
            <?=$row['name']?> 
            <input type="hidden" id="session_id" value="<?=$row['id']?>">
          </span>
            <?php }                        
          }
          else
          {
            echo "Not Logged in";
          }
          
          ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="profile.php" class="dropdown-item">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item logoutbtn">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>