<?php
session_start();
include "db.php";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])){

    $provider_id = $_POST['provider_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $booking_id = $_POST['booking_id'];
    $user_name = $_SESSION['user_name'];

    // منع تكرار التقييم لنفس الحجز
    $check = $conn->query("
        SELECT * FROM reviews 
        WHERE booking_id='$booking_id'
    ");

    if($check->num_rows == 0){

        $conn->query("
        INSERT INTO reviews (provider_id, user_name, rating, comment, booking_id)
        VALUES ('$provider_id','$user_name','$rating','$comment','$booking_id')
        ");
    }

    header("Location: my_bookings_ar.php");
    exit();
}
$user_name = $_SESSION['user_name'] ?? null;

if(!$user_name){
    header("Location: login_ar.php");
    exit();
}

/* جلب الحجوزات */
$bookings = $conn->query("
SELECT 
b.*,
p.title AS package_name,
p.price AS package_price,
pr.name AS provider_name,
pr.service_type,
pr.id AS provider_real_id
FROM bookings b
JOIN provider_packages p ON b.package_id = p.id
JOIN providers pr ON b.provider_id = pr.id
WHERE b.user_name = '$user_name'
ORDER BY b.id DESC
");
$ratings = $conn->query("
SELECT provider_id, AVG(rating) as avg_rating
FROM reviews
GROUP BY provider_id
");
$ratingMap = [];

while($r = $ratings->fetch_assoc()){
    $ratingMap[$r['provider_id']] = round($r['avg_rating'], 1);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>حجوزاتي</title>
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

<style>
.container{
    max-width:800px;
    margin:auto;
    padding:20px;
}

.card{
    background:#fff;
    padding:15px;
    margin:10px 0;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.status{
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
}

.pending{background:#ffe08a;}
.confirmed{background:#b8f2c2;}
.rejected{background:#ffb3b3;}
.paid{background:#a7c7ff;}
</style>
</head>

<body>
 <header>

        <div class="logo-section">
            <img src="logo.jpg" alt="MUZDAN Logo">
            <h1>مُـــزدان</h1>
        </div>

        <nav>
            <a href="home2_ar.php">الرئيسية</a>
            <a href="services_ar.php">الخدمات</a>
            <a href="about2_ar.php">اعرف عنّا</a>
            <a href="contact2_ar.php">تواصل معنا</a>
           
        </nav>

    </header>
<div class="container">

<h2>حجوزاتي</h2>

<?php if($bookings->num_rows == 0){ ?>
    <p>لا توجد حجوزات</p>
<?php } ?>

<?php while($b = $bookings->fetch_assoc()){ ?>
<?php
$checkReview = $conn->query("
SELECT * FROM reviews 
WHERE booking_id = '".$b['id']."'
");
?>
<div class="card">

    <h3><?= $b['provider_name'] ?></h3>
<!-- نوع الخدمة -->

    <p> نوع الخدمة: <?= $b['service_type'] ?></p>
    <p>الباقة: <?= $b['package_name'] ?></p>
     <p>السعر: <?= $b['package_price'] ?></p>
    <p>التاريخ: <?= $b['booking_date'] ?></p>

    <span class="status <?= $b['status'] ?>">
        <?= $b['status'] ?>
    </span>
<?php if($b['status'] == 'confirmed'){ ?>



<?php if($checkReview->num_rows == 0){ ?>

<form method="POST" action="">

    <input type="hidden" name="provider_id" value="<?= $b['provider_real_id'] ?>">
    <input type="hidden" name="booking_id" value="<?= $b['id'] ?>">

    <label>التقييم:</label>

    <select style="margin-top: 20px;" name="rating" required>
        <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
        <option value="4">⭐️⭐️⭐️⭐️</option>
        <option value="3">⭐️⭐️⭐️</option>
        <option value="2">⭐️⭐️</option>
        <option value="1">⭐️</option>
    </select>

    <button type="submit" name="submit_review">
        إرسال التقييم
    </button>

</form>
<?php } else { ?>
<p style="color:green;">✔️ تم تقييم الخدمة مسبقًا</p>
<?php } ?>

<?php } ?>
</div>
<?php } ?>
</div>
 <footer>
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة
    </footer>
</body>

</html>