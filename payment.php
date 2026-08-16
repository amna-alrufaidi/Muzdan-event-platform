<?php
include "db.php";
session_start();

$booking_id = $_GET['booking_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? "Guest";

$message = "";

if (!$booking_id) {
    die("Error: Missing booking ID");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $payment_method = $_POST['payment_method'];
    $receipt_name = "";

    // Bank transfer receipt upload
    if ($payment_method == "transfer") {

        if (!empty($_FILES['receipt']['name'])) {
            $receipt_name = time() . "_" . $_FILES['receipt']['name'];
            move_uploaded_file($_FILES['receipt']['tmp_name'], "uploads/" . $receipt_name);
        }
    }

    $amount = 100;

    $sql = "INSERT INTO payments 
    (booking_id, user_name, payment_method, amount, receipt_image, status)
    VALUES 
    ('$booking_id','$user_name','$payment_method','$amount','$receipt_name','paid')";

    if ($conn->query($sql)) {

        $conn->query("UPDATE bookings SET status='paid' WHERE id='$booking_id'");

        header("Location: home_ar.php");
        exit();

    } else {
        $message = $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment | Muzdan</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg" alt="Muzdan Logo">
        <h1>Muzdan</h1>
    </div>
</header>

<div class="container">

    <h2>Select Payment Method</h2>

    <p style="color:red;"><?php echo $message; ?></p>

    <form method="POST" enctype="multipart/form-data">

        <div class="payment-methods">

            <label>
                <input type="radio" name="payment_method" value="cash" required onclick="showPayment('cash')">
                Cash Payment
            </label>

            <label>
                <input type="radio" name="payment_method" value="transfer" onclick="showPayment('transfer')">
                Bank Transfer
            </label>

            <label>
                <input type="radio" name="payment_method" value="card" onclick="showPayment('card')">
                Card Payment
            </label>

            <label>
                <input type="radio" name="payment_method" value="apple" onclick="showPayment('apple')">
                Apple Pay
            </label>

        </div>

        <!-- Cash -->
        <div id="cashSection" style="display:none; margin-top:20px;">
            <p>Payment will be made upon delivery.</p>
        </div>

        <!-- Transfer -->
        <div id="transferSection" style="display:none; margin-top:20px;">
            <p><strong>Account Number:</strong> 123456789</p>

            <h3>Upload Receipt</h3>
            <input type="file" name="receipt" id="receipt">
            <p id="fileName"></p>
        </div>

        <!-- Card -->
        <div id="cardSection" style="display:none; margin-top:20px;">
            <input type="text" placeholder="Card Number"><br><br>
            <input type="text" placeholder="Card Holder Name"><br><br>
            <input type="text" placeholder="Expiry Date"><br><br>
            <input type="text" placeholder="CVV">
        </div>

        <!-- Apple Pay -->
        <div id="appleSection" style="display:none; margin-top:20px;">
            <p>Pay with Apple Pay</p>
        </div>

        <button type="submit">Complete Payment</button>

    </form>

</div>

<footer>
© 2026 Muzdan | All Rights Reserved
</footer>

<script>
function showPayment(type){

    document.getElementById("cashSection").style.display = "none";
    document.getElementById("transferSection").style.display = "none";
    document.getElementById("cardSection").style.display = "none";
    document.getElementById("appleSection").style.display = "none";

    if(type === "cash") document.getElementById("cashSection").style.display = "block";
    if(type === "transfer") document.getElementById("transferSection").style.display = "block";
    if(type === "card") document.getElementById("cardSection").style.display = "block";
    if(type === "apple") document.getElementById("appleSection").style.display = "block";
}

document.getElementById("receipt").addEventListener("change", function(){
    if(this.files.length > 0){
        document.getElementById("fileName").innerText =
        "Selected file: " + this.files[0].name;
    }
});
</script>

</body>
</html>