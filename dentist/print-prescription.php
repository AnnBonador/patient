<?php
include('authentication.php');
include('includes/header.php');
include('../admin/config/dbconn.php');
?>
<body>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
        <div class="invoice p-3 mb-3" id="prescription">
              <div class="row d-flex justify-content-start">
                  <div class="col-md-9">
                    <?php 
                      $sql = "SELECT * FROM system_details LIMIT 1";
                      $result = mysqli_query($conn,$sql);
                      while($row = mysqli_fetch_array($result))
                      {
                    ?>
                      <h4 class="text-primary text-left top_title">
                      Smile Republic Dental clinic 
                      </h4>
                      <address class="text-left text-dark">
                        <?=$row['address'];?><br>
                        <?=$row['telno'];?><br>
                        <?=$row['mobile'];?><br>
                        <?=$row['email'];?>
                      </address>
                  </div>
                  <div class="col-md-3 d-flex justify-content-end"> 
                    <img src="../upload/<?= $row['logo']?>" height="130" alt="Logo">
                  </div>
                  <?php 
                    } 
                  ?>
              </div>
                <hr>
                <?php
                if(isset($_GET['id']))
                {
                  $user_id = $_GET['id'];
                  $user = "SELECT pres.*, CONCAT(p.fname,' ',p.lname) AS pname, p.gender, p.address,pres.dose, pres.duration, d.name,pres.advice,pres.medicine,
                  DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),STR_TO_DATE(p.dob, '%c/%e/%Y'))), '%Y')+0 AS Age 
                  FROM prescription pres 
                  INNER JOIN tblpatient p ON p.id = pres.patient_id 
                  INNER JOIN tbldoctor d ON d.id = pres.doc_id 
                  WHERE pres.id='$user_id' LIMIT 1";
                  $users_run = mysqli_query($conn,$user);

                  if(mysqli_num_rows($users_run) > 0)
                  {
                      foreach($users_run as $user)
                      {                           
                ?>
                <div class="row mb-2 d-flex justify-content-start text-sm">                   
                    <div class="col-md-4">
                        Name: <?=$user['pname'];?>                       
                    </div>
                    <div class="col-md-8">
                        Addresss: <?=$user['address'];?>
                    </div>
                </div>
                <hr>
                <div class="row mb-2 d-flex justify-content-start text-sm">                   
                  <div class="col-md-3">
                    Gender: <?=$user['gender'];?>
                  </div>
                  <div class="col-md-3">
                    Age: <?=$user['Age'];?> yrs old
                  </div>
                  <div class="col-md-3">
                    Date: <?=date('M j, Y',strtotime($user['date'])); ?>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-8 mt-2">
                    <img src="../admin/assets/dist/img/prescriptionLogo.png" height="70" alt="">
                    <div class="table-responsive">
                      <table class="table table-borderless">                      
                          <thead>       
                              <th></th>
                              <th></th>
                              <th class="text-right"></th>    
                          </thead>
                          <tbody>
                          <tr>
                              <td class=""><?=$user['medicine']?></td>
                          </tr>
                          <tr>
                              <td class=""><b>Sig:</b> <?=$user['dose'].' '.$user['duration'] ?></td>
                          </tr>
                          <tr>
                              <td class=""> <?=$user['advice'] ?></td>
                          </tr>
                          </tbody>
                      </table>
                    </div>
                  </div>                
                </div>
                <div class="row text-sm">                   
                  <div class="col-md-12 text-left mb-4" style="margin-top:60px;">
                      Signature<br>
                      Lic No: <br>
                      PTR No: <br>
                  </div>                 
                </div>
                <?php
                    }
                  }
                  else
                  {
                  }
                }
                ?>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>