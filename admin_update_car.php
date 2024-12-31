<?php

include "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
$officesQuery = "SELECT OfficeID, Location FROM Offices";
$officesResult = $conn->query($officesQuery);
session_start();

if (isset($_POST['update_car'])) {
  // Get the Plate 
  $plate = isset($_POST['Plate']) ? filter_var($_POST['Plate'], FILTER_SANITIZE_STRING) : $_GET['update'];

  // Sanitize other inputs
  $price = $_POST['price'];
  $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
  $status = filter_var($_POST['Status'], FILTER_SANITIZE_STRING);
  $office = filter_var($_POST['office'], FILTER_SANITIZE_STRING);

  // Check if the car exists in the database
  $checkplate = "SELECT * FROM `car` WHERE Car_plate = ?";  
  $stmt = $conn->prepare($checkplate);
  $stmt->bind_param("s", $plate);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 0) {
      echo '<script>alert("Car plate does not exist!")</script>';
  } else {
      // Update car details
      $sql = $conn->prepare("UPDATE `car` SET status = ?, Car_price = ?, Car_detals = ?, Car_office = ? WHERE Car_plate = ?");
      $sql->bind_param("sssss", $status, $price, $details, $office, $plate);

      if ($sql->execute()) {
          echo '<script>alert("Car updated successfully!")</script>';
          header('Location: admin_addcar.php');
      } else {
          echo "Error updating record: " . $sql->error;
      }
  }

  $stmt->close();
  $conn->close();
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

 <div class="container">
 
 <section class="add-products" >

    <h1 class="heading">UPDATE CAR</h1>
    <?php
      $car_plate = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `car` WHERE Car_plate = ?");
      $select_products->bind_param("s", $car_plate);
      $select_products->execute();
      $result = $select_products->get_result(); 
      if($result->num_rows > 0){
         while($fetch_products = $result->fetch_assoc()){   
          
   ?>
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="box-container">
        <div class="inputBox">
    
            <select name="Status" id="Status" class="box" required>
            <option value="<?= $fetch_products['Status']; ?>" selected disabled><?= $fetch_products['Status']; ?> <option>
                <option value="Active">Active</option>
                <option value="Out of Service">Out of Service</option>
                <option value="Rented">Rented</option>
            </select>
            <input type="hidden" name="plate" id="plate" class="box" required placeholder="RENTING PRICE" value="<?= $fetch_products['Car_plate']; ?>">
            <input type="number" min="0" name="price" id="price" class="box" required placeholder="RENTING PRICE" value="<?= $fetch_products['Car_price']; ?>">
        </div>
        <div class="inputBox">
            <input type="file" value="<?= $fetch_products['Car_image']; ?>" name="image" id="image" class="box" accept="image/jpg, image/jpeg, image/png" >
            <select name="office" id="office" class="box" required>
                <option value="" selected disabled>Select Office</option>
                <?php
              if ($officesResult->num_rows > 0) {
               while ($office = $officesResult->fetch_assoc()) {
                $selected = ($fetch_products['Car_office'] == $office['OfficeID']) ? "selected" : "";
                      echo "<option value='" . $office['OfficeID'] . "' $selected>" . $office['Location'] . "</option>";
              }
}
?>
            </select>
            <!-- Image preview -->
            <div id="imageContainer" style="display: <?= $fetch_products['Car_image'] ? 'block' : 'none'; ?>;">
                <h3 class="heading">CAR IMAGE:</h3>
                <img id="imagePreview" src="uploads/<?= $fetch_products['Car_image']; ?>" alt="" width="150" height="150" >
            </div>
        </div>
        <div>
            <textarea name="details" id="details" class="box" required placeholder="UPDATE CAR DETAILS" cols="20" rows="5"><?= $fetch_products['Car_detals']; ?></textarea>
            
        </div>
        <input type="submit" class="btn" value="UPDATE CAR" name="update_car">
        <a href="admin_addcar.php" class="btn">GO BACK</a>
        
    </div>
              </form>
              <?php
         }
      }else{
         echo '<p class="heading">No Products Found!</p>';
      }
   ?>
   
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
    <script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                document.getElementById('imageContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
  </body>
</html>