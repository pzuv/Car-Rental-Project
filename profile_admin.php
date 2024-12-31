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
        <img src="imges\profile.png" alt="admin  Photo"> 
        </center>
    </div>
    <h1>ADMIN PROFILE</h1>
    <div class="user-info">
      <h2>Admin Information</h2> <!-- user info will be added here -->
      <p class="admin-name"><strong>Name : </strong><?php echo $_SESSION['admin_name']; ?> <span id="admin-name"></span></p>
      <p class="admin-email"><strong>Email : </strong><?php echo $_SESSION['admin_email']; ?> <span id="admin-email"></span></p>
      
    </div>
    
         <div > <!--button-->
           
           <a href="admindash.php" id="done-btn">Done</a>
         </div>
  
</body>
</html>
