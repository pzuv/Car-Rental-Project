<?php
     include "connection.php";   
     session_start();
     if(isset($_POST['submit'])){
      $conn = new mysqli($servername, $username, $password, $dbname);
      $email = $_POST['email'];
      $email = filter_var($email, FILTER_SANITIZE_STRING);
      $password = md5($_POST['password']);
      $password = filter_var($password, FILTER_SANITIZE_STRING);
   
      $sql = "SELECT * FROM `admin` WHERE email = ? AND PASSWORD = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $email, $password);
      $stmt->execute();  
      $result = $stmt->get_result();
   
      if($result->num_rows > 0){
         $admin = $result->fetch_assoc();
         
         $_SESSION['admin_name'] = $admin['name'];
         $_SESSION['admin_email'] = $admin['email'];
         
            header('location:admin.php');
      }else{
         echo '<script>alert("incorrect email or password!")</script>';

      }
   
   }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Login Form Design | CodeLab</title>
      <link rel="stylesheet" href="login.css">
   </head>
   <body>
    <nav>
        <div class="nav__header">
          <div class="nav__logo">
            <a href="home.html">EasyRide</a>
          </div>
          <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-line"></i>
          </div>
        </div>
        <ul class="nav__links" id="nav-links">
         
         
        </ul>
        
      </nav>
      <div class="wrapper">
         <div class="title">
           Welcome Boss
         </div>
         <form name="registrationForm" method="post" action="" onsubmit="return validateForm()">

            <div class="field"> <!--user enter his email-->
               <input type="text" id="email" name = "email" required >
               <label for="email"><b>Enter your email</b></label>
             </div>
             <div class="field">  <!--user enter his password-->
               <input type="password"   id="password" name = "password" required>
               <label for="password"><b>Enter your password</b></label>
               </div>
            <div class="content">
               
            </div>
            <div class="field">
               <input type="submit" value="Login" name ="submit">
               
            </div>
            <div class="signup-link">
               OOh :) <br> Are you customer? <a href="logginn.php">Go back</a>
               
            </div>
         </form>
      </div>
      <script>
         // JavaScript validation function
                 function validateForm() {
                     // Get the values of the form fields
                     var email = document.registrationForm.email.value;
                     var password = document.registrationForm.password.value;
         
                     // Validate Email
                     var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                     if (email == "" || !emailPattern.test(email)) {
                         alert("Please enter a valid email address");
                         return false;
                     }
         
                     // Validate Password
                     if (password == "") {
                         alert("Password must be filled out");
                         return false;
                     } else if (password.length < 5) {
                         alert("Password must be at least 5 characters long");
                         return false;
                     }
         
                     // If all validations pass
                     return true;  // Form is valid
                 }
         
            </script>
   </body>
</html>