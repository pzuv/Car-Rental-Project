<?php
include "connection.php";
session_start();

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Retrieve session variables
$total_cost1 = $_SESSION['cost'];
$rent_id = $_SESSION['rent_ID'];
$car_plate = $_SESSION['car_plate'];

if (isset($_POST['submit'])) {
    // Check if all credit card fields are filled
    if (isset($_POST['card_holder'], $_POST['cvv'], $_POST['card-number'], $_POST['month'], $_POST['years'])) {
        $status_payment = 'Credit Card';
        $status_rented = 'Rented';
        $status_confirmed = 'Confirmed';

        // Insert payment record for credit card
        $sql = $conn->prepare("INSERT INTO payment (rent_ID, Amount, PaymentMethod) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $rent_id, $total_cost1, $status_payment);

        if ($sql->execute()) {
            echo '<script>alert("Payment Confirmed via Credit Card!")</script>';

            // Update rent status to 'Confirmed'
            $sql1 = $conn->prepare("UPDATE `rent` SET Status = ? WHERE rent_ID = ?");
            $sql1->bind_param("ss", $status_confirmed, $rent_id);
            $sql1->execute();

            // Update car status to 'Rented'
            $sql2 = $conn->prepare("UPDATE `car` SET Status = ? WHERE Car_plate = ?");
            $sql2->bind_param("ss", $status_rented, $car_plate);
            $sql2->execute();
            echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 1000);</script>';
        } else {
            echo '<script>alert("Error: ' . $sql->error . '")</script>';
        }
    } }
    // Handle cash payment
    if (isset($_POST['pay_cash'])) {
        $status_payment = 'Cash';
        $status_rented = 'Rented';
        $status_confirmed = 'Confirmed';

        // Insert payment record for cash
        $sql = $conn->prepare("INSERT INTO payment (rent_ID, Amount, PaymentMethod) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $rent_id, $total_cost1, $status_payment);

        if ($sql->execute()) {
            echo '<script>alert("Payment Confirmed via Cash!")</script>';

            // Update rent status to 'Confirmed'
            $sql1 = $conn->prepare("UPDATE `rent` SET Status = ? WHERE rent_ID = ?");
            $sql1->bind_param("ss", $status_confirmed, $rent_id);
            $sql1->execute();

            // Update car status to 'Rented'
            $sql2 = $conn->prepare("UPDATE `car` SET Status = ? WHERE Car_plate = ?");
            $sql2->bind_param("ss", $status_rented, $car_plate);
            $sql2->execute();
            echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 1000);</script>';
        } else {
            echo '<script>alert("Error: ' . $sql->error . '")</script>';
        }
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirm</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form name="Payment" method="post" action="" onsubmit="return validateForm()">
        <div class="container">
            <h1>Confirm Your Payment</h1>
            <div class="first-row">
                <div class="owner">
                    <h3>Card Holder</h3>
                    <div class="input-field">
                        <input type="text" id="card_holder" name="card_holder" required>
                    </div>
                </div>
                <div class="cvv">
                    <h3>CVV</h3>
                    <div class="input-field">
                        <input type="password" id="cvv" name="cvv" required>
                    </div>
                </div>
            </div>
            <div class="second-row">
                <div class="card-number">
                    <h3>Card Number</h3>
                    <div class="input-field">
                        <input type="text" id="card_number" name="card-number" required>
                    </div>
                </div>
            </div>
            <div class="third-row">
                <h3>Expiration Date</h3>
                <div class="selection">
                    <div class="date">
                        <select name="month" id="month" required>
                            <option value="Jan">Jan</option>
                            <option value="Feb">Feb</option>
                            <option value="Mar">Mar</option>
                            <option value="Apr">Apr</option>
                            <option value="May">May</option>
                            <option value="Jun">Jun</option>
                            <option value="Jul">Jul</option>
                            <option value="Aug">Aug</option>
                            <option value="Sep">Sep</option>
                            <option value="Oct">Oct</option>
                            <option value="Nov">Nov</option>
                            <option value="Dec">Dec</option>
                        </select>
                        <select name="years" id="years"  required>
                        
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                            <option value="2033">2033</option>
                            <option value="2034">2034</option>
                        </select>
                    </div>
                    <div class="cards">
                        <img src="imges\mc.png" alt="">
                        <img src="imges\vi.png" alt="">
                        <img src="imges\pp.png" alt="">
                   
                </div>
            </div>
            <input type="submit" id="submit" name="submit">
            
            <a href ="index.php" class="btn">BACK</a>
            </form>
            <div class="headerr__content"><h1>PAY CASH</h1></div>
            <form name="Payment2" method="post" action="">
    <input type="submit" class="btn" value="PAY CASH" name="pay_cash"> 
    </form> 
        </div>
        </div>
    </form>
<style>*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: azure;
}

.container{
    width: 750px;
    height: 500px;
    border: 1px solid;
    background-color: white;
    display: flex;
    flex-direction: column;
    padding: 40px;
    justify-content:space-around;
}

.container h1{
    text-align: center;
}

.first-row{
     display: flex;
}

.owner{
    width: 100%;
    margin-right: 40px;
}

.input-field{
    border: 1px solid #999;
}

.input-field input{
    width: 100%;
    border:none;
    outline: none;
    padding: 10px;
}

.selection{
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.selection select{
    padding: 10px 20px;
}

#submit{
    border: 0;
    background-color: rgb(0, 14, 71);
    color: white;
    text-align: center;
    text-transform: uppercase;
    text-decoration: none;
    padding: 10px;
    font-size: 18px;
    transition: 0.5s;
    cursor: pointer;
}

#submit:hover{
    background-color: dodgerblue;
}

.cards img{
    width: 100px;
}</style>
    <script>
       

        // Validation function
        function validateForm() {
            // Get the values of the form fields
            const card_holder = document.Payment.card_holder.value.trim();
            const cvv = document.Payment.cvv.value.trim();
            const card_number = document.Payment["card-number"].value.trim();

            // Validate card_holder (letters only)
            if (!/^+$/.test(card_holder)) {
                alert("Card Holder must contain only letters.");
                return false;
            }

            // Validate CVV (exactly 3 digits)
            if (!/^\d$/.test(cvv)) {
                alert("CVV must be exactly 3 digits.");
                return false;
            }

            // Validate card_number (exactly 14 digits)
            if (!/^\d$/.test(card_number)) {
                alert("Card Number must be exactly 14 digits.");
                return false;
            }

            // If all validations pass
            alert("Payment Confirmed!");
            return true;
        }
    </script>
    <stayle>
        
</body>
</html>
