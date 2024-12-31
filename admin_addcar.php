<?php

include "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
$officesQuery = "SELECT OfficeID, Location FROM Offices";
$officesResult = $conn->query($officesQuery);
session_start();
$category = $_POST['category'] ?? null;
// ADD CAR
if(isset($_POST['add_car'])){
  
  $modle = $_POST['modle'];
  $modle = filter_var($modle, FILTER_SANITIZE_STRING);
  $category = $_POST['category'];
  $category = filter_var($category, FILTER_SANITIZE_STRING);
  $year = $_POST['year'];
  $plate = $_POST['Plate'];
  $plate = filter_var($plate, FILTER_SANITIZE_STRING);
  $price = $_POST['price'];
  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_STRING);
  $status = $_POST['status'];
  $status = filter_var($status, FILTER_SANITIZE_STRING);
  $office = $_POST['office'];
  $office = filter_var($office, FILTER_SANITIZE_STRING);
// Handle image upload
$image = $_FILES['image']['name'];
$imageTmpName = $_FILES['image']['tmp_name'];
$imageFolder = "uploads/" . basename($image);

// Ensure the uploads directory exists
if (move_uploaded_file($imageTmpName, $imageFolder)) {
    
} else {
    echo "Failed to upload image!";
}
    $checkplate="SELECT * FROM `car` WHERE Car_plate = ?";  
    $stmt = $conn->prepare($checkplate);
    $stmt->bind_param("s", $plate);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("Car plate already exist!")</script>';

    
        }else{
    $sql = $conn->prepare("INSERT INTO car (Year,status, Car_Modle, Car_plate ,Car_type, Car_price, Car_detals, Car_office, Car_image) VALUES(?,?,?,?,?,?,?,?,?)");

        if ($sql->execute([$year,$status, $modle,$plate ,$category , $price, $details, $office, $image])) {
          echo '<script>alert("New car added successfully!")</script>';
          
        } else {
          echo '<script>alert("New car added successfully!")</script>';
        }
    } 
    header('location:admin_addcar.php');
    $conn->close();
    $stmt->close();
  }
  if(isset($_POST['delete_car'])){
    $plate = $_POST['delete_plate'];
    $plate = filter_var($plate, FILTER_SANITIZE_STRING);

  // Check for existing rentals for this car
  $checkQuery = "SELECT COUNT(*) AS rent_count FROM rent WHERE Car_plate = ?";
  $checkStmt = $conn->prepare($checkQuery);
  $checkStmt->bind_param("s", $plate);
  $checkStmt->execute();
  $result = $checkStmt->get_result();
  $row = $result->fetch_assoc();
  $rentCount = $row['rent_count'];
  $checkStmt->close();

if ($rentCount > 0) {
    // If rentals exist, ask user for action
    echo '<script>
        alert("There are existing rentals for this car.");
    </script>';
    echo '<script>setTimeout(function(){ window.location.href = "admin_addcar.php"; }, 20);</script>';
} else {


    //no rentals found , delete the car
    $query = "DELETE FROM car WHERE Car_plate = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $plate);
    if ($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
          echo '<script>alert("Car deleted successfully!");</script>';
          
      } else {
          echo '<script>alert("Car not found!");</script>';
      }
  } else {
      echo '<script>alert("Error: Unable to delete car.");</script>';
  }
  $stmt->close();
    header('location:admin_addcar.php');
}
  $conn->close();
}

if(isset($_GET['delete_car2'])){
  $plate = $_GET['delete_car2'];
  $plate = filter_var($plate, FILTER_SANITIZE_STRING);
   // Check for existing rentals for this car
   $checkQuery = "SELECT COUNT(*) AS rent_count FROM rent WHERE Car_plate = ?";
   $checkStmt = $conn->prepare($checkQuery);
   $checkStmt->bind_param("s", $plate);
   $checkStmt->execute();
   $result = $checkStmt->get_result();
   $row = $result->fetch_assoc();
   $rentCount = $row['rent_count'];
   $checkStmt->close();

   if ($rentCount > 0) {
       // If rentals exist, ask user for action
       echo '<script>
           alert("There are existing rentals for this car.");
       </script>';
       echo '<script>setTimeout(function(){ window.location.href = "admin_addcar.php"; }, 20);</script>';
   } else {
   // No rentals found, delete the car
  $query = "DELETE FROM car WHERE Car_plate = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $plate);
  if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo '<script>alert("Car deleted successfully!");</script>';
        header('location:admin_addcar.php');
    } 
} else {
    echo '<script>alert("Error: Unable to delete car.");</script>';
}
$stmt->close();
$conn->close();
header('location:admin_addcar.php');
   }
$conn->close();
}
// add new office
if(isset($_POST['add_office'])){
  
  $addOffice = $_POST['addOffice'];
  $addOffice = filter_var($addOffice, FILTER_SANITIZE_STRING);
    $checkoffice="SELECT * FROM `offices` WHERE Location = ?";  
    $stmt = $conn->prepare($checkoffice);
    $stmt->bind_param("s", $addOffice);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script>alert("Office already exist!")</script>';

    
        }else{
    $sql = $conn->prepare("INSERT INTO offices (Location) VALUES(?)");

        if ($sql->execute([$addOffice])) {
          echo '<script>alert("New Office added successfully!")</script>';
          
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } 
    header('location:admin_addcar.php');
    $conn->close();
    $stmt->close();

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

    <h1 class="heading" id = "add_Car">ADD NEW CAR</h1>
 
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="box-container" >
        <div class="inputBox">
            <input type="text" name="modle" id="modle" class="box" required placeholder="ENTER CAR MODLE">
            <select class="box" name="category" id="category" required>
                <option value="" selected disabled>SELECT CATEGORY</option>
                <option value="Sedan">SEDAN</option>
                <option value="SUV">SUV</option>
                <option value="Electric">ELECTRIC</option>
                <option value="Sport">SPORT</option>
            </select>
            <input type="number" min="2000" name="year" id="year" class="box" required placeholder="ENTER THE YEAR">
            <select name="status" id="status" class="box" required>
                <option value="" selected disabled>Select Status</option>
                <option value="Active">Active</option>
                <option value="Out of Service">Out of Service</option>
                <option value="Rented">Rented</option>
            </select>
        </div>
        <div class="inputBox">
            <input type="text" name="Plate" id="plate" class="box" required placeholder="ENTER CAR PLATE">
            <input type="number" min="0" name="price" id="price" class="box" required placeholder="RENTING PRICE">
            <input type="file" name="image" id="image" class="box" accept="image/jpg, image/jpeg, image/png">
            <select name="office" id="office" class="box" required>
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
            <!-- Image preview -->
            <div id="imageContainer" style="display: none;">
                <h3 class="heading"> Car Image:</h3>
                <img id="imagePreview" src="" alt="" width="200" height="150">
            </div>
        </div>
        <div>
            <textarea name="details" id="details" class="box" required placeholder="ENTER CAR DETAILS" cols="50" rows="10"></textarea>
            <input type="submit" class="btn" value="ADD CAR" name="add_car">
        </div>
    </div>
</form>
 <section class="add-products" >
 <form action="" method="POST" >
       <div class="box-container">
            <h1 class="heading">DELETE BY PLATE</h1>
            <div>
            
            <input type="text" id="search_plate" name="delete_plate" class="box" placeholder="Enter Car Plate" required>
            <input type="submit" class="btn" value="DELETE CAR" name="delete_car">
            
            </div>
              </form>
        
          </section>
</section>
<section class="add-products" >
 <form action="" method="POST" >
       <div class="box-container">
            <h1 class="heading">ADD NEW OFFICE</h1>
            <div>
            <input type="text" id="addOffice" name="addOffice" class="box" placeholder="ENTER OFFICE NAME">
            <input type="submit" class="btn" value="ADD OFFICE" name="add_office">
            </div>
              </div>
              
              </form>
        
          </section>
</section>
<div>
        <h1 class="heading">CATEGORIES</h1>
        <div class="box-container">
            <div class="box">
            <form action="" method="POST">
                <img src="imges/sedan.png" alt="">
                <h3>Sedan</h3>
                <p>Sedan cars are comfortable, fuel-efficient cars perfect for daily commutes and family trips!</p>
                <button type="submit" name="category" value="Sedan" class="btn">Sedan</button>
            </div>
            <div class="box">
                <img src="imges/suv.png" alt="">
                <h3>SUV</h3>
                <p>SUVs are the choice for the perfect blend of comfort, versatility, and adventure!</p>
                <button type="submit" name="category" value="SUV" class="btn">SUV</button>
            </div>
            <div class="box">
                <img src="imges/electric.png" alt="">
                <h3>Electric</h3>
                <p>Drive into the future with an electric car – clean, efficient, and ready to power your journey!</p>
                <button type="submit" name="category" value="Electric" class="btn">Electric</button>
            </div>
            <div class="box">
                <img src="imges/sport.png" alt="">
                <h3>Sports</h3>
                <p>Life's too short to drive boring cars – pick the perfect sports car and flex with it!</p>
                <button type="submit" name="category" value="Sport" class="btn">Sports</button>
             </form>
            </div>
        </div>
    </div>
<h1 class="heading">Cars Added</h1>

<div class="box-container">

<?php
$show_cars_query = "SELECT c.* FROM Car c";
if (!empty($category)) {
    $show_cars_query .= " WHERE c.Car_type = ?";
}
$stmt = $conn->prepare($show_cars_query);
if (!empty($category)) {
    $stmt->bind_param("s", $category);
}
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($fetch_car = $result->fetch_assoc()) {
?>
    <div class="box">
        <div class="price">£<?= htmlspecialchars($fetch_car['Car_price']); ?>/DAY</div>
        <img src="uploads/<?= htmlspecialchars($fetch_car['Car_image']); ?>" alt="Car Image">
        <div class="heading"><?= htmlspecialchars($fetch_car['Car_Modle']); ?></div>
        <div class="cat"><?= htmlspecialchars($fetch_car['Car_type']); ?></div>
        <div class="details"><?= htmlspecialchars($fetch_car['Car_detals']); ?></div>
        <div class="cat">PLATE : <?= htmlspecialchars($fetch_car['Car_plate']); ?></div>
        <div class="flex-btn">
            <a href="admin_update_car.php?update=<?= $fetch_car['Car_plate']; ?>" class="btn" id="Update_Car">Update</a>
            <a href="admin_addcar.php?delete_car2=<?= $fetch_car['Car_plate']; ?>" class="btn" onclick="return confirm('Delete this car?');">Delete</a>
        </div>
    </div>
<?php
    }
} else {
    echo '<h1 class="heading">No cars added yet!</h1>';
}
 
?>
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