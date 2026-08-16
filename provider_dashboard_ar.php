<?php
session_start();
include "db.php";


if(!isset($_SESSION['provider_id'])){
    header("Location: login_ar.php");
    exit();
}

$provider_id = $_SESSION['provider_id'];
if(isset($_POST['add_unavailable'])){

    $date = $_POST['unavailable_date'];

    $conn->query("
    INSERT INTO unavailable_dates
    (provider_id, unavailable_date)
    VALUES
    ('$provider_id','$date')
    ");
}
$booking_count = $conn->query("
SELECT COUNT(*) as total
FROM bookings
WHERE provider_id='$provider_id'
")->fetch_assoc();

$bookings = $conn->query("

SELECT *

FROM bookings

WHERE provider_id='$provider_id'

ORDER BY id DESC

");

/* ===== جلب البيانات ===== */
$provider = $conn->query("SELECT * FROM providers WHERE id='$provider_id'")->fetch_assoc();
$social = $conn->query("
SELECT * FROM social_links
WHERE provider_id='$provider_id'
")->fetch_assoc();
$packages = $conn->query("SELECT * FROM provider_packages WHERE provider_id='$provider_id'");

$unavailable_dates = $conn->query("
SELECT *
FROM unavailable_dates
WHERE provider_id='$provider_id'
ORDER BY unavailable_date ASC
");
$messages = $conn->query("
SELECT * FROM messages
WHERE provider_id='$provider_id'
AND message_type='provider'
ORDER BY id DESC
");
if(isset($_POST['accept_booking'])){

    $booking_id = $_POST['booking_id'];

    $conn->query("
    UPDATE bookings
    SET status='accepted'
    WHERE id='$booking_id'
    ");

    header("Location: provider_dashboard_ar.php");
    exit();
}

if(isset($_POST['reject_booking'])){

    $booking_id = $_POST['booking_id'];

    $conn->query("
    UPDATE bookings
    SET status='rejected'
    WHERE id='$booking_id'
    ");

    header("Location: provider_dashboard_ar.php");
    exit();
}
/* ===== تحديث بيانات مقدم الخدمة ===== */
if(isset($_POST['update_provider'])){
    $phone = $_POST['phone'];
    $snapchat = $_POST['snapchat'];
    $instagram = $_POST['instagram'];
    $tiktok = $_POST['tiktok'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    $conn->query("
    UPDATE providers
SET location='$location',
    description='$description',
    phone='$phone'
WHERE id='$provider_id'
    ");
$check = $conn->query("
SELECT id
FROM social_links
WHERE provider_id='$provider_id'
");

if($check->num_rows > 0){

    $conn->query("
    UPDATE social_links
    SET snapchat='$snapchat',
        instagram='$instagram',
        tiktok='$tiktok'
    WHERE provider_id='$provider_id'
    ");

}else{

    $conn->query("
    INSERT INTO social_links
    (provider_id,snapchat,instagram,tiktok)
    VALUES
    ('$provider_id','$snapchat','$instagram','$tiktok')
    ");
}
    header("Location: provider_dashboard_ar.php");
    exit();
}
/* ===== إضافة باقة ===== */
if(isset($_POST['add_package'])){

    $title = $_POST['new_title'];
    $price = $_POST['new_price'];

    $conn->query("
    INSERT INTO provider_packages
    (provider_id, title, price)
    VALUES
    ('$provider_id','$title','$price')
    ");

    header("Location: provider_dashboard_ar.php");
    exit();
}
/* ===== تعديل باقة ===== */
if(isset($_POST['update_package'])){

    $id = $_POST['package_id'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $conn->query("
    UPDATE provider_packages 
    SET title='$title', price='$price'
    WHERE id='$id'
    ");

    header("Location: provider_dashboard_ar.php");
    exit();
}

/* ===== حذف باقة ===== */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $conn->query("DELETE FROM provider_packages WHERE id='$id'");

    header("Location: provider_dashboard_ar.php");
    exit();
}
if(isset($_GET['delete_date'])){

    $id = $_GET['delete_date'];

    $conn->query("
    DELETE FROM unavailable_dates
    WHERE id='$id'
    ");

    header("Location: provider_dashboard_ar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<title>لوحة التحكم - مُزدان</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

<style>
.dashboard-container{
    max-width:900px;
    margin:auto;
}

.section-card{
    background:#fff;
    padding:20px;
    margin:20px 0;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.section-title{
    margin-bottom:15px;
    font-size:18px;
    font-weight:bold;
}

input, textarea{
    width:100%;
    padding:10px;
    margin:8px 0;
    border-radius:8px;
    border:1px solid #ddd;
}
button{
    margin-top:10px;
}
.package-box{
    border:1px solid #eee;
    padding:15px;
    margin:10px 0;
    border-radius:10px;
}
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
}
</style>

</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg">
        <h1>مُـــزدان  </h1>
    </div>

    <nav>
        <a href="logout.php">تسجيل خروج</a>
    </nav>
</header>
<div class="section-card">

<h3>
عدد الحجوزات:
<?= $booking_count['total']; ?>
</h3>




<div class="dashboard-container">

<!-- ===== بياناتي ===== -->
<div class="section-card">

<div class="section-title">بياناتي</div>

<form method="POST">

<label>الموقع</label>
<input type="text" name="location" value="<?= $provider['location'] ?>">

<label>الوصف</label>
<textarea name="description"><?= $provider['description'] ?></textarea>
<label>رقم الجوال</label>
<input type="text" name="phone" value="<?= $provider['phone'] ?>">

<label>سناب شات</label>
<input type="text" name="snapchat" value="<?= $social['snapchat'] ?? '' ?>">

<label>إنستغرام</label>
<input type="text" name="instagram" value="<?= $social['instagram'] ?? '' ?>">

<label>تيك توك</label>
<input type="text" name="tiktok" value="<?= $social['tiktok'] ?? '' ?>">

<button type="submit" name="update_provider" class="register-btn" 
                         style="width:25%; border:none; padding:12px; border-radius:8px;">
حفظ التعديلات
</button>

</form>

</div>

<!-- ===== الباقات ===== -->
<div class="section-card">

<div class="section-title">الباقات والخدمات</div>
<form method="POST" class="package-box">

<label>اسم الخدمة الجديدة</label>
<input type="text" name="new_title" required>

<label>السعر</label>
<input type="number" name="new_price" required>

<button type="submit"
        name="add_package"
        class="register-btn"
        style="width:25%; border:none; padding:12px; border-radius:8px;">
إضافة خدمة
</button>

</form>
<?php while($p = $packages->fetch_assoc()){ ?>

<div class="package-box">

<form method="POST">

<input type="hidden" name="package_id" value="<?= $p['id'] ?>">

<label>اسم الباقة</label>
<input type="text" name="title" value="<?= $p['title'] ?>">

<label>السعر</label>
<input type="number" name="price" value="<?= $p['price'] ?>">

<button type="submit" name="update_package" class="register-btn" 
                         style="width:25%; border:none; padding:12px; border-radius:8px;">
تعديل
</button>

<a href="?delete=<?= $p['id'] ?>" style="color:red;margin-right:10px;">
حذف
</a>

</form>

</div>

<?php } ?>
<div class="section-card">

<div class="section-title">
الحجوزات
</div>

<?php while($booking = $bookings->fetch_assoc()){
    $payment = $conn->query("
SELECT *
FROM payments
WHERE booking_id='{$booking['id']}'
")->fetch_assoc();
 ?>

<div class="package-box">

<p>
العميل:
<?= $booking['user_name']; ?>
</p>

<p>
التاريخ:
<?= $booking['booking_date']; ?>
</p>
<p>

طريقة الدفع:

<?php

$method = $payment['payment_method'] ?? '';

if($method == 'apple_pay') echo 'ابل باي';

elseif($method == 'transfer') echo 'تحويل بنكي';

elseif($method == 'cash') echo 'كاش';

elseif($method == 'credit_card') echo 'بطاقة ائتمانية';

else echo 'غير محدد';

?>

</p>
<?php if($method == 'transfer'){ ?>
<p>
ايصال الدفع:
<br>
<?php if(!empty($payment['receipt_image'])){ ?>

        <img src="uploads/<?= $payment['receipt_image']; ?>" width="120">

    <?php } else { ?>

        <p>لم يتم رفع الإيصال</p>

    <?php } ?>
</p>
<?php } ?>

<p>
الحالة:
<?= $booking['status']; ?>
</p>

<form method="POST">

<input type="hidden"
       name="booking_id"
       value="<?= $booking['id']; ?>">

<button type="submit"
        name="accept_booking">
قبول
</button>

<button type="submit"
        name="reject_booking">
رفض
</button>

</form>

</div>

<?php } ?>

</div>
</div>
<div class="section-card">

<div class="section-title">
📩 الرسائل من العملاء
</div>

<?php while($m = $messages->fetch_assoc()){ ?>

<div class="package-box">

    <p><b> المستخدم:</b> <?= $m['user_name'] ?></p>

    <p><b> الرسالة:</b> <?= $m['message'] ?></p>

    <p><b> الرد:</b> <?= $m['reply'] ?? 'لا يوجد رد' ?></p>

    <form method="POST" action="reply_message.php">

        <input type="hidden" name="message_id" value="<?= $m['id'] ?>">

        <textarea name="reply" placeholder="اكتب الرد هنا..." required></textarea>

        <button type="submit" class="register-btn"
                style="width:25%; border:none; padding:12px; border-radius:8px;">
            إرسال رد
        </button>

    </form>

</div>

<?php } ?>

</div>
<div class="section-card">



<h3>الأيام غير المتاحة</h3>

<form method="POST">

<input type="date"
       name="unavailable_date"
       required>

<button type="submit"
        name="add_unavailable" class="register-btn" 
        style="width:25%; border:none; padding:12px; border-radius:8px;">
إضافة يوم غير متاح
</button>

</form>


<h3>الأيام المحجوزة</h3>

<?php while($d = $unavailable_dates->fetch_assoc()){ ?>

<div class="package-box">

<?= $d['unavailable_date']; ?>

<a href="?delete_date=<?= $d['id']; ?>"
   style="color:red;float:left;">
حذف
</a>

</div>

<?php } ?>
</div>
</div>
</div>

<footer>
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة
</footer>
</body>
</html>