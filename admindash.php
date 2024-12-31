<?php

include "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <title> EasyRide</title>
  </head>
  <body>
    <header>
    <nav>
        
        <div class="nav__header">
          <div class="nav__logo">
            <a href="#">EasyRide</a>
          </div>
          <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-line"></i>
          </div>
        </div>
        <ul class="nav__links" id="nav-links">
        <a> Welcome <?php echo $_SESSION['admin_name']; ?></a>
           <li><a href="admin_addcar.php#add_Car">ADD CAR</a></li>
          <li><a href="admin_addcar.php#addOffice">ADD OFFICE</a></li>
          <li><a href="admin_addcar.php#Update_Car">UPDATE CAR</a></li>
          <li><a href="admin_addcar.php#Update_Car">CARS</a></li>
          <li><a href="admin.php">SEARCH</a></li>
          <li><a href="admindash.php">DASHBOARD</a></li>
        </ul>
        <ul>
          <div class="profile" onclick="toggleDropdown()">
              <img src="imges\profile.png" alt="User  Photo"> 
          </div>
          <div class="dropdown" id="myDropdown">
              <a href="profile_admin.php">Profile</a>
              <a href="logout.php">Log Out</a>
          </div>
        
        </ul>

      </nav>

      <section class="dashboard">
    <div class="container">

      <h1 class="heading" >DASHBOARD</h1>
  
      <div class="box-container">
  
      <div class="box">
  <?php
     $status = "Confirmed";
     $status2= "Picked Up";
     $status3= "Returned";
     
     $select_pendings = $conn->prepare("SELECT * FROM `rent` WHERE Status = ? or Status=? or Status =? ");
     $select_pendings->bind_param("sss", $status,$status2, $status3);
     $select_pendings->execute();
     $result = $select_pendings->get_result();
  ?>
  <h1 class="heading"><?= $result->num_rows; ?></h1>
  <h3>COMPLETED ORDERS</h3>
  <a href="admin.php" class="btn">SEE ORDERS</a>
</div>


      <div class="box">
      <?php
     $select_pendings = $conn->prepare("SELECT * FROM `car`");
     $select_pendings->execute();
     $result = $select_pendings->get_result();
  ?>
  <h1 class="heading"><?= $result->num_rows; ?></h1>
        <h3>TOTAL CARS</h3>
        <a href="admin_addcar.php" class="btn">SEE CARS</a>
        </div>

      <div class="box">
      <?php
     $select_pendings = $conn->prepare("SELECT * FROM `customers`");
     $select_pendings->execute();
     $result = $select_pendings->get_result();
  ?>
  <h1 class="heading"><?= $result->num_rows; ?></h1>
        <h3>TOTAL USERS</h3>
        <a href="admin.php" class="btn">SEE USERS</a>
        </div>
        <div class="box">
      <?php
      $status = "CASH";
     $select_pendings = $conn->prepare("SELECT * FROM `payment` WHERE PaymentMethod = ?");
     $select_pendings->bind_param("s", $status);
     $select_pendings->execute();
     $result = $select_pendings->get_result();
  ?>
  <h1 class="heading"><?= $result->num_rows; ?></h1>
        <h3>TOTAL CASH PAYMENTS</h3>
        <a href="admin.php" class="btn">SEE PAYMENTS</a>
        </div>
        <div class="box">
      <?php
      $status = "Credit Card";
     $select_pendings = $conn->prepare("SELECT * FROM `payment` WHERE PaymentMethod = ?");
     $select_pendings->bind_param("s", $status);
     $select_pendings->execute();
     $result = $select_pendings->get_result();
  ?>
  <h1 class="heading"><?= $result->num_rows; ?></h1>
        <h3>TOTAL CARD PAYMENTS</h3>
        <a href="admin.php" class="btn">SEE PAYMENTS</a>
        </div>
        
      </div>
     </div>
</section>
  </header>
  <footer>
      <div class="section__container footer__bar">
        <h4>EasyRide</h4>
        <p>Copyright © 2024 EasyRide . All rights reserved.</p>
        <ul class="footer__socials">          
        </ul>
      </div>
    </footer>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
  </body>
</html>