<?php
include "connection.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$filtered_results = [];
$columns = [];

if (isset($_POST["apply_method"])) {
    $method = $_POST['method'];
    $from = $_POST['from'];
    $to = $_POST['to'];

    if ($method === "All reservations") {
        $query = $conn->prepare("
            SELECT r.rent_ID AS 'Rent ID', 
                   cu.name AS 'Customer Name', 
                   cu.email AS 'Customer Email', 
                   c.Car_plate AS 'Car Plate', 
                   c.Car_Modle AS 'Car Model', 
                   r.pickup_date AS 'Pickup Date', 
                   r.return_date AS 'Return Date',
                   r.rent_created_at AS 'Rent Time'
            FROM rent r
            JOIN car c ON r.car_plate = c.Car_plate
            JOIN customers cu ON r.customer_ID = cu.CustomerID
            WHERE r.pickup_date >= ? AND r.return_date <= ?");
        $query->bind_param("ss", $from, $to);
        $columns = ['Rent ID', 'Customer Name', 'Customer Email', 'Car Plate', 'Car Model', 'Pickup Date', 'Return Date', 'Rent Time'];
    } elseif ($method === "Status Of All Cars") {
        $specific_date = $from; // Use 'from' as the specific date
        $query = $conn->prepare("
            SELECT 
                c.Car_plate AS 'Car Plate', 
                c.Car_Modle AS 'Car Model', 
                o.Location AS 'Office',
                CASE 
                    WHEN r.rent_ID IS NOT NULL AND ? NOT BETWEEN r.pickup_date AND r.return_date THEN 'Available'
                    ELSE c.Status 
                END AS status
            FROM car c
            LEFT JOIN offices o ON c.Car_office = o.OfficeID
            LEFT JOIN rent r ON c.Car_plate = r.car_plate
            GROUP BY c.Car_plate, c.Car_Modle, o.Location, status");
        $columns = ['Car Plate', 'Car Model', 'Office', 'status'];
        $query->bind_param("s", $specific_date);
    } elseif ($method === "Daily payments") {
        $query = $conn->prepare("
            SELECT 
                py.paymentID AS 'Payment ID', 
                py.Amount AS 'Amount', 
                py.PaymentMethod AS 'Payment Method', 
                py.PaymentDate AS 'Payment Date' 
            FROM payment py 
            WHERE DATE(py.PaymentDate) >= ? AND DATE(py.PaymentDate) <= ?");
        $columns = ['Payment ID', 'Amount', 'Payment Method', 'Payment Date'];
        $query->bind_param("ss", $from, $to);
    } else {
        echo "Invalid method";
    }

    

    // Check if the query was set
    if (isset($query)) {
        $query->execute();
        $filtered_results = $query->get_result();

        // Debugging: Check if any results are returned
        if ($filtered_results->num_rows > 0) {
            
        } else {
            echo "No results found for Customer ID: $userID.<br>";
        }
    }
}
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
                <a href="">EasyRide</a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <a>Welcome <?php echo $_SESSION['admin_name']; ?></a>
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
    <section class="my-section section__container steps__container" id="search">
    <div class="headerr__content"><h2>Welcome Boss</h2></div>
    <div class="form-wrapper">
            <div class="headerr__container" id="home">
                <form action="searchByID.php" method="POST" class="form__container">                  
                  <div class="input__group">
                    <div class="input-group">
                        <label for="customerId">Search by CustomerID</label>
                        <input type="text" placeholder="Enter Customer ID" id="customerId" name="customerId" required />
                    </div>
                  </div>
                  <button type = "submit" class="btnadmin">
                    <i class="ri-search-line"></i>
                  </button>
                </form>
            </div>
        <div class="headerr__container" id="home">
            <div class="headerr__content"><h1>SEARCH BY METHOD</h1></div>
            <form action="" method="POST" class="form__container">
                <div class="input__group">
                    <label for="method">Choose The Method</label>
                    <select name="method" id="method" required>
                        <option value="" disabled selected>Select a method</option>
                        <option value="All reservations">All reservations</option>
                        <option value="Status Of All Cars">Status Of All Cars</option>
                        <option value="Daily payments">Daily payments</option>
                    </select>
                </div>
                <div class="input__group">
                    <label for="from">FROM</label>
                    <input type="date" name="from" id="from"  required/>
                </div>
                <div class="input__group">
                    <label for="to">TO</label>
                    <input type="date" name="to" id="to"  required/>
                </div>
                
                <button href ="#results"class="btnadmin" type="submit" name = "apply_method">
                    <i class="ri-search-line"></i>
                </button> 
                
            </form>
        </div>
       
    </section>
    <section class="dashboard" id = "results">
        <div class="profile-container">
            <div class="user-rentals">
                <div class="headerr__content"><h1>RESULTS</h1></div>
                <table>
                <thead>
                    <tr>
                    <?php
                    if (!empty($columns)) {
                        foreach ($columns as $column) {
                            echo "<th>$column</th>";
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($filtered_results)) {
                    while ($row = $filtered_results->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($columns as $col) {
                            echo "<td>{$row[$col]}</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='" . count($columns) . "'>No results found</td></tr>";
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</header>
<footer>
    <div class="section__container footer__bar">
        <h4>EasyRide</h4>
        <p>Copyright © 2024 EasyRide . All rights reserved.</p>
    </div>
</footer>
<script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
</body>
<style>
    .profile-container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      margin-top: 50px;
    }
    .user-rentals {
      width: 80%;
      margin: 0 auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table thead {
      background-color:rgb(145, 145, 145);
    }
    table th,
    table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
      color:rgb(0, 0, 0);
    }
    table th {
      background-color:rgb(0, 0, 0);
      color:rgb(255, 255, 255);
    }
    table tr:nth-child(even) {
      background-color:rgb(255, 255, 255);
    }
    </style>
</html>
