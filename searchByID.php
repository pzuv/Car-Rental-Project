<?php

include "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
session_start();
if (isset($_POST['customerId'])) {
  $userid = $_POST['customerId'];




}


$userid = $_POST['customerId'];

$show_user = $conn->prepare("
       SELECT * FROM customers WHERE CustomerID=?
");
$show_user->bind_param("i", $userid);
$show_user->execute();
$result1 = $show_user->get_result();


$show_rents = $conn->prepare("
        SELECT 
            cu.Name AS 'Customer Name',
            cu.Email AS 'Customer Email',
            cu.PhoneNumber AS 'PhoneNumber',
            r.rent_ID AS 'Rent ID',
            r.pickup_date AS 'Pickup Date',
            r.return_date AS 'Return Date',
            c.Car_plate AS 'Car Plate',
            r.status AS 'Status',
            r.rent_ID AS 'Rent ID',
            c.Car_Modle AS 'Car Model'
        FROM rent r
        JOIN customers cu ON r.customer_ID = cu.CustomerID  -- Corrected column name
        JOIN car c ON r.car_plate = c.car_plate
        WHERE cu.CustomerID = ? ");
$show_rents->bind_param("i", $userid);
$show_rents->execute();
$result = $show_rents->get_result();

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
      <h2>User Information</h2>  
      <?php 
    if ($result->num_rows > 0) {   
      ?>


<?php
                if ($result1->num_rows > 0) {
                    while ($office = $result1->fetch_assoc()) {
                        
                ?>

<!-- user info will be added here -->
      <p class="user-name"><strong>Name : </strong><?php echo $office['Name']; ?> <span id="user-name"></span></p>
      <p class="user-email"><strong>Email : </strong><?php echo $office['Email']; ?><span id="user-email"></span></p>
      <p class="user-phone"><strong>Phone : </strong><?php echo $office['PhoneNumber']; ?> <span id="user-phone"></span></p>
    </div>

   <?php
   }
  } else {
      echo "<option value='' disabled>No offices available</option>";
  }
    ?>

    <div class="user-rentals">
      <h2>User Rentals</h2>
      <table>
        <thead>
          <tr>
          <th>Status</th>
            <th>Rent ID</th>
            <th>Pickup Date</th>
            <th>Return Date</th>
            <th>Car Plate</th>
            <th>Car Model</th>
            <th>MANAGE</th>
          </tr>
        </thead>
        <?php
        while ($rents = $result->fetch_assoc()) {
          
?>
        <tbody id="rentals-list">
        <tr>
<td><?php echo $rents['Status']; ?></td>
<td><?php echo $rents['Rent ID']; ?></td>
<td><?php echo $rents['Pickup Date']; ?></td>
<td><?php echo $rents['Return Date']; ?></td>
<td><?php echo $rents['Car Plate']; ?></td>
<td><?php echo $rents['Car Model']; ?></td>
<td><a href="manageCarAdmin.php?rent_ID=<?php echo $rents["Rent ID"];?>"> MANAGE </a></td>
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
           
           <a href="admin.php" id="done-btn">Done</a>
         </div>
  
</body>
</html>
