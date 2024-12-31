<?php
include "connection.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
$officesQuery = "SELECT OfficeID, Location FROM Offices";
$officesResult = $conn->query($officesQuery);
$start = $_POST['start'] ?? null;
$stop = $_POST['stop'] ?? null;
$location = $_POST['location'] ?? null;
$category = $_POST['category'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>EasyRide</title>
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
        <h1 class="heading">CATEGORIES</h1>
        <div class="box-container">
            <div class="box">
            <form action="" method="POST">
            <input type="hidden" name="start" value="<?= htmlspecialchars($start ?? '') ?>">
            <input type="hidden" name="stop" value="<?= htmlspecialchars($stop ?? '') ?>">
            <input type="hidden" name="location" value="<?= htmlspecialchars($location ?? '') ?>">
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

    <div class="container">
    <h1 class="heading">AVAILABLE CARS</h1>
    <div class="box-container">
        <?php
        if ($start && $stop && $location) {
            $query = "
        SELECT c.* 
        FROM Car c 
        WHERE c.Car_office = ?
    ";

    // Add category filter if selected
    if ($category) {
        $query .= " AND c.Car_type = ?";
    }

    // Exclude cars that are out of service or have conflicting rental dates
    $query .= "
        AND c.Status NOT IN ('Out of Service') 
        AND NOT EXISTS (
            SELECT 1
            FROM rent r
            WHERE r.Car_plate = c.Car_plate
            AND r.Status NOT IN ('Cancelled', 'Returned')
            AND (
                (r.pickup_date <= ? AND r.return_date >= ?) OR
                (r.pickup_date <= ? AND r.return_date >= ?) OR
                (r.pickup_date >= ? AND r.return_date <= ?)
            )
        )
    ";
        
            // Prepare the query to prevent injection
            $stmt = $conn->prepare($query);
        
            // Bind parameters based on whether a category is selected
            if ($category) {
                $stmt->bind_param("ssssssss", $location, $category, $start, $start, $stop, $stop, $start, $stop);
            } else {
                $stmt->bind_param("sssssss", $location, $start, $start, $stop, $stop, $start, $stop);
            }
        
        

            $stmt->execute();
            $result = $stmt->get_result();

            // Display the filtered cars
            if ($result->num_rows > 0) {
                while ($fetch_car = $result->fetch_assoc()) {
                    ?>
                    <form action="newrent.php" method="POST" class="form__container">
                        <div class="box">
                            <div class="price">£<?= htmlspecialchars($fetch_car['Car_price']); ?>/DAY</div>
                            <img src="uploads/<?= htmlspecialchars($fetch_car['Car_image']); ?>" alt="Car Image">
                            <div class="heading"><?= htmlspecialchars($fetch_car['Car_Modle']); ?></div>
                            <div class="cat"><?= htmlspecialchars($fetch_car['Car_type']); ?></div>
                            <div class="details"><?= htmlspecialchars($fetch_car['Car_detals']); ?></div>
                            <div class="flex-btn">
                                <input type="hidden" name="Car_plate" value="<?= htmlspecialchars($fetch_car['Car_plate']) ?>">
                                <input type="hidden" name="start" value="<?= htmlspecialchars($start) ?>">
                                <input type="hidden" name="end" value="<?= htmlspecialchars($stop) ?>">
                                <input type="hidden" name="location" value="<?= htmlspecialchars($location) ?>">
                                <button type="submit" class="btn">Rent Now</button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            } else {
                echo '<h1 class="heading">No cars available for the selected category!</h1>';
            }
        } else {
            echo '<h1 class="heading">Please select dates, location, and category first.</h1>';
        }
        ?>
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
    </div>
</footer>
<script src="https://unpkg.com/scrollreveal"></script>
<script src="main.js"></script>
</body>
</html>
