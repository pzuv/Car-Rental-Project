<?php

include "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
    
    
  <div class="profile-container">
    <div class="profile" onclick="toggleDropdown()">
        <center>
        <img src="imges\profile.png" alt="User  Photo"> 
        </center>
    </div>
    <h1>User Profile</h1>
    <div class="user-info">
      <h2>User Information</h2> <!-- user info will be added here -->
      <p class="user-name"><strong>Name : </strong><?php echo $_SESSION['customer_name']; ?> <span id="user-name"></span></p>
      <p class="user-email"><strong>Email : </strong><?php echo $_SESSION['customer_email']; ?> <span id="user-email"></span></p>
      <p class="user-phone"><strong>Phone : </strong><?php echo $_SESSION['customer_phone']; ?> <span id="user-phone"></span></p>
    </div>
    <?php 
    $login_customer = $_SESSION['customer_ID']; 
    $show_rents = $conn->prepare("SELECT * 
    FROM car c, rent r
    WHERE r.customer_ID = ? AND c.Car_plate=r.car_plate ");
    $show_rents->bind_param("s", $login_customer);
    $show_rents->execute();
    $result = $show_rents->get_result();

    if ($result->num_rows > 0) {

      
?>
    <div class="user-rentals">
      <h2>Car Rentals</h2>
      <table>
        <thead>
          <tr>
          <th>Status</th>
            <th>Rent Date</th>
            <th>Car Model</th>
            <th>Plate ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Total Amount</th>
            <th>Action</th>
          </tr>
        </thead>
        <?php
        while ($rents = $result->fetch_assoc()) {
?>
        <tbody id="rentals-list">
        <tr>
<td><?php echo $rents["Status"]; ?></td>
<td><?php echo $rents["rent_created_at"]; ?></td>
<td><?php echo $rents["Car_Modle"]; ?></td>
<td><?php echo $rents["Car_plate"]; ?></td>
<td><?php echo $rents["pickup_date"]; ?></td>
<td><?php echo $rents["return_date"]; ?></td>
<td>£<?php echo $rents["cost"]; ?></td>
<td><a href="manageCar.php?rent_ID=<?php echo $rents["rent_ID"];?>"> MANAGE </a></td>
<?php        } ?>
        </tbody>
      </table>
    </div>
    <?php } else {
            ?>
             <div class="container">
      <div class="jumbotron">
        <h1 class="text-center">You have not rented any cars till now!</h1>
        <p class="text-center"> Please rent cars in order to view your data here. </p>
      </div>
    </div>

            <?php
        } ?> 
  </div>
         <div > <!--button-->
           
           <a href="index.php" id="done-btn">Done</a>
         </div>
  
</body>
</html>
