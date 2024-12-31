<?php
include "connection.php";

if(isset($_POST['submit'])){
    $conn = new mysqli($servername, $username, $password, $dbname);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $password = md5($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $passport = $_POST['passport'];
    $passport = filter_var($passport, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $age = $_POST['age'];
    $address = $_POST['address'];

    $checkEmail="SELECT * FROM `customers` WHERE Email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("user email already exist!")</script>';

    
        }else{
              $insert = $conn->prepare("INSERT INTO `customers`(Name, Passport_number, Email,age,Address,PhoneNumber, PASSWORD) VALUES(?,?,?,?,?,?,?)");
              if ($insert->execute([$name, $passport, $email, $age, $address, $number, $password])) {
                echo '<script>alert("Registration successful!")</script>';
                header("location: logginn.php");
            } else {
                echo "Error inserting data: ";
                print_r($insert->errorInfo());
            }
           }
        }      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="login.css">  
     </head>
<body>

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
         
         
        </ul>
        
      </nav>
      <div class="wrapper">
        <div class="title">
           SignUp Form
        </div>
            <form name="registrationForm" method="post" action="" onsubmit="return validateForm()">

                <div class="field"> <!--user enters his name-->
                    <input type="text" id="name" name = "name" required >
                    <label for="name"><b>Enter your Name:</b></label>
                    
                </div>
                  <br>

                  <div class="field"> <!--user enters his phone number-->
                    <input type="text" id="number" name ="number" required>
                    <label for="number"><b>Enter your Phone Number:</b></label>
                    
                </div>
                  <br>  

                  <div class="field"> <!--user enters his passport-->
                    <input type="text" id="passport" name ="passport"required>
                    <label for="passport"><b>Enter your Passport Number:</b></label>
                </div>
                  <br>  
            
                <div class="field"> <!--user enters his email-->
                    <input type="text" id="email" name ="email"required>
                    <label for="email"><b>Enter your Email:</b></label>
                </div>
                <br>
            
                <div class="field"> <!--user enters his age-->
                    <input type="number" id="age" name ="age"required>
                    <label for="age"><b>Enter your Age:</b></label>
                </div>
                <br>

                <div class="field">   <!--user enter his address-->
                    <input  type="text" id="address" name ="address" required>
                    <label for="address"><b>Enter your Address:</b></label>
                </div>
                <br>
            
                <div class="field">   <!--user create password-->
                    <input  type="password" id="password" name ="password"required>
                    <label for="password"><b>Create a Password:</b></label>
                </div>
                <br>
            
                <div class="field"> <!--submit button-->
                    <input class="button" type="submit" name = "submit">
                </div>
                <div class="signup-link">
            a member? <a href="logginn.php">Login Here</a>
            <br>
            Are you an Admin ? <a href="adminlog.php">login</a>
         </div>
      </div>
            </form>
        </div>
    </blockquote>
    <script>
        // JavaScript validation function
    function validateForm() {
    // Get the values of the form fields
    var name = document.registrationForm.name.value;
    var number=document.registrationForm.number.value;
    var email = document.registrationForm.email.value;
    var passport = document.registrationForm.passport.value;
    var password = document.registrationForm.password.value;
    var address = document.registrationForm.address.value;
    var age = document.registrationForm.age.value; // Assuming age exists in the form

    // Validate Name
    if (name == "") {
        alert("Name must be filled out");
        return false;
    }

    // Validate phone number
    if (number== "") {
        alert("You must enter your number");
        return false;
    } else if (!/^[0-9]+$/.test(number)) {
        alert("Phone Number must be in numbers only");
        return false;
    }

    // Validate National ID
    if (passport == "") {
        alert("You must enter your Passport Number");
        return false;
    } else if (passport.length < 5 ) {
        alert("National ID must be more then 5 digits");
        return false;
    }
    else if ( passport.length > 14) {
        alert("National ID must be not more then 14 digits");
        return false;
    }

    // Validate Email
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (email == "" || !emailPattern.test(email)) {
        alert("Please enter a valid email address");
        return false;
    }

    // Validate Age
    if (age == "") {
        alert("Age must be filled out");
        return false;
    } else if (age < 21) {
        alert("You must be at least 21 years old to register");
        return false;
    }

    // Validate Password
    if (password == "") {
        alert("Password must be filled out");
        return false;
    } else if (password.length < 6) {
        alert("Password must be at least 6 characters long");
        return false;
    }

    // Validate Address
    if (address == "") {
        alert("You must enter your address");
        return false;
    }

    // If all validations pass
    alert("Registration successful!");
    return true; // Form is valid
}

    </script>

   
</body>
</html>