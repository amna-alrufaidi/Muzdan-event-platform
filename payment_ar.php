<?php
include "db.php";
session_start();

$booking_id = $_GET['booking_id'] ?? null;
if(!$booking_id){
    die("❌ لا يوجد رقم حجز");
}
$user_name = $_SESSION['user_name'] ?? "Guest";

$message = "";
$booking = $conn->query("
SELECT b.*, p.price
FROM bookings b
JOIN provider_packages p ON b.package_id = p.id
WHERE b.id = '$booking_id'
")->fetch_assoc();
 $amount = $booking['price'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $payment_method = $_POST['payment_method'];
    $receipt_name = "";

    if ($payment_method == "transfer") {

        if (!empty($_FILES['receipt']['name'])) {
            $receipt_name = time() . "_" . $_FILES['receipt']['name'];
            move_uploaded_file($_FILES['receipt']['tmp_name'], "uploads/" . $receipt_name);
        }
    }

    $status = "pending";
    $sql = "INSERT INTO payments 
    (booking_id, user_name, payment_method, amount, receipt_image, status)
    VALUES 
    ('$booking_id','$user_name','$payment_method','$amount','$receipt_name','$status')";

    if ($conn->query($sql)) {

        $conn->query("
UPDATE bookings 
SET status='confirmed'
WHERE id='$booking_id'
");
$conn->query("
UPDATE providers 
SET bookings_count = bookings_count + 1
WHERE id = (
    SELECT provider_id FROM bookings WHERE id='$booking_id'
)
");

       echo "<script>
alert('تم الحجز بنجاح 🎉');
window.location.href='my_bookings_ar.php';
</script>";
exit();

    } else {
        $message = $conn->error;
    }
}
$provider = $conn->query("
SELECT pr.iban
FROM providers pr
JOIN bookings b ON b.provider_id = pr.id
WHERE b.id = '$booking_id'
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الدفع | مُــزدان</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg" alt="MUZDAN Logo">
        <h1>مُــزدان</h1>
    </div>
     <nav>
            <a href="home2_ar.php">الرئيسية</a>
            <a href="services_ar.php">الخدمات</a>
            <a href="about2_ar.php">اعرف عنّا</a>
            <a href="contact2_ar.php">تواصل معنا</a>
           
        </nav>
</header>

<div class="container">

    <h2>اختر طريقة الدفع</h2>
    <p style="font-size:20px;font-weight:bold;">
المبلغ المطلوب: <?= $amount ?> ريال
</p>

    <p style="color:red;"><?php echo $message; ?></p>

    <form method="POST" enctype="multipart/form-data">

        <div class="payment-methods">

            <label>
                <input type="radio" name="payment_method" value="cash" required onclick="showPayment('cash')">
                الدفع كاش
            </label>

            <label>
                <input type="radio" name="payment_method" value="transfer" onclick="showPayment('transfer')">
                تحويل بنكي
            </label>

            <label>
                <input type="radio" name="payment_method" value="card" onclick="showPayment('card')">
                بطاقة بنكية
            </label>

            <label>
                <input type="radio" name="payment_method" value="apple" onclick="showPayment('apple')">
                Apple Pay
            </label>

        </div>

        <!-- كاش -->
        <div id="cashSection" style="display:none; margin-top:20px;">
            <p>سيتم الدفع عند مقابلة مقدم الخدمة.</p>
        </div>

        <!-- تحويل -->
        <div id="transferSection" style="display:none; margin-top:20px;">
            <p><strong> الآيبان:</strong> <?= $provider['iban'] ?></p>

            <h3>إرفاق الإيصال</h3>
            <input type="file" name="receipt" id="receipt">
            <p id="fileName"></p>
        </div>

        <!-- بطاقة -->
        <div id="cardSection" style="display:none; margin-top:20px;">
            <input type="text" placeholder="رقم البطاقة"><br><br>
            <input type="text" placeholder="اسم حامل البطاقة"><br><br>
            <input type="text" placeholder="تاريخ الانتهاء"><br><br>
            <input type="text" placeholder="CVV">
        </div>

        <!-- Apple Pay -->
        <div id="appleSection" style="display:none; margin-top:20px;">
            <p>الدفع عبر Apple Pay</p>
        </div>

        <button type="submit">إتمام الدفع</button>

    </form>

</div>

<footer>
© 2026 مُــزدان | جميع الحقوق محفوظة
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
        "تم اختيار الملف: " + this.files[0].name;
    }
});
</script>
<footer>
           © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة 

</footer>
</body>
</html>