<?php

include "connection.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_POST['Car_plate'], $_POST['start'], $_POST['end'],$_POST['location'])) {
  $car_plate = $_POST['Car_plate'];
  $start = $_POST['start'];
  $stop = $_POST['end'];
  $location = $_POST['location'];



 $location_query = $conn->prepare("SELECT Location FROM Offices WHERE OfficeID = ?");
 $location_query->bind_param("s", $location);
 $location_query->execute();
 $location_result = $location_query->get_result();
 $location_name = $location_result->fetch_assoc()['Location'];

}

//new rent
if(isset($_POST['new_rent'])){
  $location = $_POST['location_ID'];
  $start_date = $_POST['pickup_date'];
  $end_date = $_POST['return_date'];
  $customer_ID = $_POST['customer_ID'];
  $customer_ID = filter_var($customer_ID, FILTER_SANITIZE_STRING);
  $car_plate = $_POST['car_plate'];
  $car_plate = filter_var($car_plate, FILTER_SANITIZE_STRING);
  $status = 'Reserved';
  $total_cost2 = $_SESSION['cost'];
  $status2 = 'Rented';
  $_SESSION['car_plate'] = $_POST['car_plate'];
  function dateDiff($start, $stop) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($stop);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
  }
  $err_date = dateDiff($start_date, $end_date);
  if($err_date >= 0) {  
    $sql = $conn->prepare("INSERT INTO rent (office_ID, pickup_date, return_date, customer_ID, car_plate, cost, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $location, $start_date, $end_date, $customer_ID, $car_plate, $total_cost2, $status);
    
    if ($sql->execute()) {
        echo '<script>alert("New Rent added successfully!")</script>';
        $sql2 = $conn->prepare("SELECT rent_ID FROM rent WHERE car_plate = ? AND customer_ID = ? AND pickup_date = ? AND return_date = ?");
        $sql2->bind_param("ssss", $car_plate , $customer_ID, $start_date, $end_date);
        $sql2->execute();  
        $result1 = $sql2->get_result();
   
      if($result1->num_rows > 0){
         $rent = $result1->fetch_assoc();
         $_SESSION['rent_ID'] = $rent['rent_ID'];
      }
        header('location:payment.php');
    } else {
        echo '<script>alert("Error: ' . $sql->error . '")</script>';
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
            <a href="#">EasyRide</a>
          </div>
          <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-line"></i>
          </div>
        </div>
        <ul class="nav__links" id="nav-links">
        <a href=""> WELCOME <?php echo $_SESSION['customer_name']; ?></a>
        <li><a href="profile.php">MY RENTS</a></li>
        <li><a href="index.php">CARS</a></li>
        </ul>
        <ul>
          <div class="profile" onclick="toggleDropdown()">
              <img src="imges\profile.png" alt="User  Photo"> 
          </div>
          <div class="dropdown" id="myDropdown">
              <a href="profile.php">Profile</a>
              <a href="logout.php">Log Out</a>
          </div>
        
        </ul>

      </nav>
 <div class="container">
 <section class="add-products" >

    <h1 class="heading">NEW RENT</h1>
    <?php
      $start_date_obj = new DateTime($start);
      $end_date_obj = new DateTime($stop);
      $interval = $start_date_obj->diff($end_date_obj);
      $days_rented = $interval->days;
   
      $select_products = $conn->prepare("SELECT * FROM `car` WHERE Car_plate = ?");
      $select_products->bind_param("s", $car_plate);
      $select_products->execute();
      $result = $select_products->get_result();
      
      if($result->num_rows > 0){
         while($fetch_products = $result->fetch_assoc()){   
          $total_cost = $fetch_products['Car_price'] * $days_rented;
          $_SESSION['cost'] = $fetch_products['Car_price'] * $days_rented;
               
   ?>
   
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="box-container">
        <div class="inputBox">
            <div id="imageContainer" >
                <h3 class="heading"> Car Image:</h3>
                <img src="uploads/<?= htmlspecialchars($fetch_products['Car_image']); ?>" alt="Car Image">
            </div>
            <h1> Selected Car :&nbsp;  <b><?= $fetch_products['Car_Modle']; ?></b></h1>
            <h1> Plate ID :&nbsp;  <b><?= $fetch_products['Car_plate']; ?></b></h1>
            <h1> Price :&nbsp;  <b><?= $fetch_products['Car_price']; ?> </b></h1>
            
            
            
        </div>
        <div class="box-container">
        <input type="hidden" name="pickup_date" value="<?= htmlspecialchars($start) ?>">
        <input type="hidden" name="location_ID" value="<?= htmlspecialchars($location) ?>">
        <input type="hidden" name="return_date" value="<?= htmlspecialchars($stop) ?>">
        <input type="hidden" name="customer_ID" value="<?= $_SESSION['customer_ID'] ?>">
        <input type="hidden" name="car_plate" value="<?= $fetch_products['Car_plate']; ?>">
        <input type="hidden" name="cost" value="<?= number_format($total_cost, 2) ?>">
            <h1><strong>Clint Name :</strong> <?= $_SESSION['customer_name'] ?></h1>
            <h1><strong>Clint Phone :</strong> <?= $_SESSION['customer_phone'] ?></h1>
            <h1><strong>Pickup Location :</strong> <?= htmlspecialchars($location_name); ?></h1>
            <h1><strong>Pickup Date :</strong> <?= htmlspecialchars($start) ?></h1>
            <h1><strong>Return Date :</strong> <?= htmlspecialchars($stop) ?></h1>
            <h1><strong>Number of Days:</strong> <?= $days_rented ?> days</h1>
            <h1><strong>Total Cost:</strong> £<?= number_format($total_cost, 2) ?></h1>
            
        </div>
        
    </div>  
    <a href ="index.php"class="btn">Back</a>
            <input type="submit" class="btn" value="CONFIRM" name="new_rent">
</form>
<?php
         }
         
      }else{
         echo '<p class="heading">No Products Found!</p>';
      }
   ?>
</section>
</div>
   </div>
     </div>
  </header>
    <footer>
      <div class="section__container footer__container">
        <div class="footer__col">
          <h4>Our Products</h4>
          <ul class="footer__links">
            
            <li><a href="#">Cars</a></li>
            <li><a href="#">Packages</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Priceline</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>About EasyRide</h4>
          <ul class="footer__links">
            <li><a href="#">Why EasyRide</a></li>
            <li><a href="#">Our Story</a></li>
            
          </ul>
        </div>
        
        <div class="footer__col">
          <h4>Extras</h4>
          <ul class="footer__links">
           
            <li><a href="#">View Booking</a></li>
            <li><a href="#">New Offers</a></li>
          </ul>
        </div>
      </div>
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