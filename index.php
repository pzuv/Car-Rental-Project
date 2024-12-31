<?php

include "connection.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
$officesQuery = "SELECT OfficeID, Location FROM Offices";
$officesResult = $conn->query($officesQuery);



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
        <a> WELCOME <?php echo $_SESSION['customer_name']; ?></a>
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
      
          
      <section class="my-section section__container steps__container" id="rent">
        <div class="headerr__container" id="home">
          <div class="header__content"><h1>New Rent</h1></div>
          <form action="cars.php" method="POST" class="form__container">
            <div class="input__group">
              <label for="location">Country - City</label>
              <select name="location" id="office" class="box" required>
                <option value="" selected disabled>Select Office</option>
                <?php
                if ($officesResult->num_rows > 0) {
                    while ($office = $officesResult->fetch_assoc()) {
                        echo "<option value='" . $office['OfficeID'] . "'>" . $office['Location'] . "</option>";
                    }
                } else {
                    echo "<option value='' disabled>No offices available</option>";
                }
                ?>
            </select>
            </div>
            <?php $today = date("Y-m-d") ?>
            <div class="input__group">
            <label for="start">Pickup Date</label>
            <input
        type="date"
        name="start"
        id="start"
        min="<?php echo($today);?>"
        required
    />
</div>
<div class="input__group">
    <label for="stop">Return Date</label>
    <input
        type="date"
        name="stop"
        id="stop"
        min="<?php echo($today);?>"
        required
    />
</div>
            
            <button type="submit" class="btn">
              <i class="ri-search-line"></i> Search
            </button>
          </form>
          </div>
        </div>
    </header>
    <footer>
      <div class="section__container footer__container">
        <div class="footer__col">
          <h4>Our Products</h4>
          <ul class="footer__links">
            
            <li><a href="cars.php">Cars</a></li>
            
            
          </ul>
        </div>
        <div class="footer__col">
          <h4>About EasyRide</h4>
          <ul class="footer__links">
            <li><a href="home.php#service">Why EasyRide</a></li>
            <li><a href="home.php#home">Our Story</a></li>
            
          </ul>
        </div>
        
        <div class="footer__col">
          <h4>Extras</h4>
          <ul class="footer__links">
           
            <li><a href="profile.php">View Booking</a></li>
            
          </ul>
        </div>
      </div>
      <div class="section__container footer__bar">
        <h4>EasyRide</h4>
        <p>Copyright © 2024 EasyRide . All rights reserved.</p>
        <ul class="footer__socials">
          <li>
            <a href="facebook.com"><i class="ri-facebook-fill"></i></a>
          </li>
          <li>
            <a href="twitter.com"><i class="ri-twitter-fill"></i></a>
          </li>
          <li>
            <a href="google.com"><i class="ri-google-fill"></i></a>
          </li>
        </ul>
      </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
  </body>
</html>