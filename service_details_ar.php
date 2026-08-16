<?php
$conn = mysqli_connect("localhost","root","","muzdan");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$bookings_count = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total 
FROM bookings 
WHERE provider_id=$id
"));
$rating = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT AVG(rating) AS avg_rating
FROM reviews
WHERE provider_id=$id
"));

$provider = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM providers WHERE id=$id
"));

$social = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM social_links WHERE provider_id=$id
"));

$packages = mysqli_query($conn,"
SELECT * FROM provider_packages WHERE provider_id=$id
");

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تفاصيل الخدمة</title>

<link rel="stylesheet" href="style.css">
<title>مُـــزدان</title>
      <link rel="stylesheet" href="style.css">
      <script src="script.js" defer></script>
      <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">



   
<style>
.container_d{
    max-width:1100px;
    margin:auto;
    padding:20px;
}

/* أهم إصلاح */
.hero_d{
    display:flex;
    flex-direction:row;
    justify-content:space-between;
    align-items:flex-start;
    gap:30px;
}

/* الصورة يسار */
.hero-img_d{
    width:35%;
    justify-items: right;
}

.hero-img_d img{
    width:100%;
    height:320px;
    object-fit:cover;
    border-radius:15px;
}

/* المعلومات يمين */
.hero-info_d{
    width:60%;
    min-width:300px;
}

.badge_d{
    display:inline-block;
    background:#f3d6e0;
    padding:6px 12px;
    border-radius:10px;
    margin-top:10px;
}

/* الباقات */
.packages_d{
    margin-top:40px;
}

.package-grid_d{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

.package_d{
    border:1px solid #eee;
    padding:15px;
    border-radius:12px;
    text-align:center;
}

/* التواصل */
.contact_d{
    margin-top:40px;
    border-top:1px solid #eee;
    padding-top:20px;
}

/* تصغير للجوال */
@media(max-width:768px){
    .hero_d{
        flex-direction:column;
    }

    .hero-img_d, .hero-info_d{
        width:100%;
    }
}
</style>

</head>

<body>

 <!-- ===== Header ===== -->

    <header>

        <div class="logo-section">
            <img src="logo.jpg" alt="MUZDAN Logo">
            <h1>مُـــزدان</h1>
        </div>
        
        <nav>
            <a href="home2_ar.php">الرئيسية</a>
            <a href="services_ar.php">الخدمات</a>
            <a href="my_bookings_ar.php">حجوزاتي</a>
            <a href="about2_ar.php">اعرف عنّا</a>
            <a href="contact2_ar.php">تواصل معنا</a>
        
        </nav>

    </header>

<div class="container_d">

<!-- HERO -->
<div class="hero_d">

   

    <!-- معلومات -->
    <div class="hero-info_d">
        <h1 style="color:#b56480;">تفاصيل مقدم الخدمة</h1>
        <h2 ><?= $provider['name'] ?></h2>

        <p style="font-size: larger; font-weight:bold; margin-top: 12px; color:#b56480;">وصف الخدمة :</p>
        <p style="font-size: larger;"><?= $provider['description'] ?></p>
        <p style="font-size: larger; margin-top: 8px;">📍 الموقع :<?= $provider['location'] ?></p>
        <p style="font-size: larger;">⭐ التقييم العام: <?= round($rating['avg_rating'],1) ?: 0 ?></p>
        <p class="badge_d " style="font-size: larger;">🔖 عدد الحجوزات: <?= $bookings_count['total'] ?></p>
        <!-- التواصل -->


<h3 style=" color:#b56480; margin-top: 50px;">تواصل مع مقدم الخدمة</h3>

<form method="POST" action="send_message.php" style="margin-top:15px;">

    <input type="hidden" name="service_id" value="<?= $provider['id'] ?>">
    <input type="hidden" name="provider_id" value="<?= $provider['id'] ?>">

    <textarea name="message" placeholder="اكتب رسالتك هنا..." 
        style="width:50%; height:50px; padding:10px; border-radius:10px; border:1px solid #ccc;"
        required></textarea>
<br>
    <button type="submit"
        style="margin-bottom:10px; margin-top:5px; background:#b56480; color:white; padding:8px 20px; border:none; border-radius:8px;">
        إرسال الرسالة
    </button>

</form>
<?php $hasSocial = false; ?>

<?php if(!empty($provider['phone'])){ ?>
    <p>📞 الجوال: <?= $provider['phone'] ?></p>
    <?php $hasSocial = true; ?>
<?php } ?>

<?php if(!empty($social['snapchat'])){ ?>
    <p>👻 سناب: <?= $social['snapchat'] ?></p>
    <?php $hasSocial = true; ?>
<?php } ?>

<?php if(!empty($social['instagram'])){ ?>
    <p>📸 إنستغرام: <?= $social['instagram'] ?></p>
    <?php $hasSocial = true; ?>
<?php } ?>

<?php if(!empty($social['tiktok'])){ ?>
    <p>🎵 تيك توك: <?= $social['tiktok'] ?></p>
    <?php $hasSocial = true; ?>
<?php } ?>

<?php if(!$hasSocial){ ?>
    <p>لا توجد حسابات مضافة</p>
<?php } ?>

</div>

     <!-- صورة -->
    <div class="hero-img_d">
        <img src="uploads/<?= $provider['logo'] ?>">
    </div>

</div>

<!-- الباقات -->
<div class="packages_d">

<h3 style="color:#b56480;">الخدمات المتاحة</h3>

<div class="package-grid_d">

<?php while($p = mysqli_fetch_assoc($packages)){ ?>

<div class="package_d">

    <h4><?= $p['title'] ?></h4>

    <p style="color:#b56480;font-weight:bold;">
        <?= $p['price'] ?> ريال
    </p>

    <form method="GET" action="calendar_ar.php">

        <input type="hidden" name="provider_id" value="<?= $provider['id'] ?>">
        <input type="hidden" name="package_id" value="<?= $p['id'] ?>">

        <button class="register-btn" 
                         style="width:25%; border:none; padding:12px; border-radius:8px;">
            اختيار
        </button>

    </form>

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