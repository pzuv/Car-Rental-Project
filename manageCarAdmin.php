<?php

include "connection.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);



 // pickup the car
if(isset($_POST['picup_rent'])){
  $rentid = $_POST['rent_id'];
  $car_plate = $_POST['car_plate'];
  $status = 'Picked Up';
  $status2 = 'Rented';
  $status = filter_var($status, FILTER_SANITIZE_STRING); 
    $sql = $conn->prepare("UPDATE `rent` SET Status = ? WHERE rent_ID = ?");
    $sql->bind_param("ss",$status, $rentid);
    if ($sql->execute()) {
      $sql = $conn->prepare("UPDATE `car` SET Status = ? WHERE Car_Plate = ?");
      $sql->bind_param("ss",$status2, $car_plate);
    if($sql->execute()){
        echo '<script>alert("Pickup successfully!")</script>';
        echo '<script>setTimeout(function(){ window.location.href = "admin.php"; }, 20);</script>';
      }
        
     else {
        echo '<script>alert("NOT DONE")</script>';
    }
     $conn->close();
  }
}
   // return the car
if(isset($_POST['return_rent'])){
  $rentid = $_POST['rent_id'];
  $car_plate = $_POST['car_plate'];
  $status = 'Returned';
  $status2 = 'Active';
  $status = filter_var($status, FILTER_SANITIZE_STRING); 
    $sql = $conn->prepare("UPDATE `rent` SET Status = ? WHERE rent_ID = ?");
    $sql->bind_param("ss",$status, $rentid);
    if ($sql->execute()) {
      $sql = $conn->prepare("UPDATE `car` SET Status = ? WHERE Car_Plate = ?");
      $sql->bind_param("ss",$status2, $car_plate);
    if($sql->execute()){
        echo '<script>alert("Return successfully!")</script>';
        echo '<script>setTimeout(function(){ window.location.href = "admin.php"; }, 20);</script>';
      }
        
     else {
        echo '<script>alert("NOT DONE")</script>';
    }
     $conn->close();
  }
}
  // cancel the rent
  if(isset($_POST['cancel_rent'])){
    $rentid = $_POST['rent_id'];
    $car_plate = $_POST['car_plate'];
    $status = 'Cancelled';
    $status2 = 'Active';
    $status = filter_var($status, FILTER_SANITIZE_STRING); 
      $sql = $conn->prepare("UPDATE `rent` SET Status = ? WHERE rent_ID = ?");
      $sql->bind_param("ss",$status, $rentid);
      if ($sql->execute()) {
        $sql = $conn->prepare("UPDATE `car` SET Status = ? WHERE Car_Plate = ?");
        $sql->bind_param("ss",$status2, $car_plate);
        $sql = $conn->prepare("UPDATE `payment` SET PaymentMethod = ? WHERE rent_ID = ?");
        $sql->bind_param("ss",$status, $rentid);
      if($sql->execute()){
          echo '<script>alert("Cancel successfully!")</script>';
          echo '<script>setTimeout(function(){ window.location.href = "admin.php"; }, 20);</script>';
        }
          
       else {
          echo '<script>alert("NOT DONE")</script>';
      }
       $conn->close();
    }
  }
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
                <a href="">EasyRide</a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <a>Welcome <?php echo $_SESSION['admin_name']; ?></a>
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
      <?php
function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}
if (isset($_GET['rent_ID']) && !empty($_GET['rent_ID'])) {
  $rentid = $_GET['rent_ID'];
 $sql1 = "SELECT 
    c.Car_Modle, 
    c.Car_Plate, 
    r.pickup_date, 
    r.return_date, 
    r.rent_created_at, 
    o.Location, 
    u.Name, 
    u.PhoneNumber, 
    c.Car_image
FROM 
    rent r
JOIN 
    car c ON c.Car_Plate = r.car_plate
JOIN 
    customers u ON u.customerID = r.customer_ID
JOIN 
    offices o ON r.office_ID = o.OfficeID
WHERE 
    r.rent_ID = '$rentid'";
 $result1 = $conn->query($sql1);
 if ($result1->num_rows > 0) {
    while($row = mysqli_fetch_assoc($result1)) {
        $car_name = $row["Car_Modle"];
        $car_plate = $row["Car_Plate"];
        $name = $row["Name"];
        $PhoneNumber = $row["PhoneNumber"];
        $pickup_date = $row["pickup_date"];
        $return_date = $row["return_date"];
        $rent_created_at = $row["rent_created_at"];
        $location = $row["Location"];
        $image = $row["Car_image"];
        $no_of_days = dateDiff("$pickup_date", "$return_date");
    }

?>
 <div class="container">
 <section class="add-products" >
    <h1 class="heading">MANAGE RENT</h1>
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="box-container">
        <div class="inputBox">
            <div id="imageContainer" >
                <h3 class="heading"> Car Image:</h3>
                <img src="uploads/<?= htmlspecialchars($image); ?>" alt="Car Image">
            </div>
        </div>
        <div class="box-container">
        <input type="hidden" name="rent_id" value="<?= htmlspecialchars($rentid) ?>">
        <input type="hidden" name="car_plate" value="<?= htmlspecialchars($car_plate) ?>">
            <h1><strong>Name : </strong> <?php echo($name);?></h1>
            <h1><strong>Phone : </strong> <?php echo($PhoneNumber);?></h1>
            <h1><strong>Pickup Location : </strong> <?php echo($location);?></h1>
            <h1><strong>Pickup Date : </strong> <?php echo($pickup_date);?></h1>
            <h1><strong>Return Date : </strong> <?php echo($return_date);?></h1>
            <h1><strong>Car Modle : </strong> <?php echo($car_name);?></h1>
            <h1><strong>Car Plate : </strong><?php echo($car_plate);?></h1>
            
        </div>
        
    </div>  
    <a href ="admin.php"class="btn">BACK</a>
    <input type="submit" class="btn" value="PICKUP" name="picup_rent">
    <input type="submit" class="btn" value="RETURN" name="return_rent">
    <input type="submit" class="btn" value="CANCEL" name="cancel_rent">
</form>
<?php
         }else{
         echo '<p class="heading">No Products Found!</p>';
        }
      } else {
          echo '<p class="heading">Invalid or Missing Rent ID!</p>';
      }
   ?>
</section>
</div>
   </div>
     </div>
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