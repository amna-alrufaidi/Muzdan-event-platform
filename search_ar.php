<?php
$q = trim($_GET['q'] ?? '');

$services = [
    "التصوير" => "photography_ar.php",
    "القاعات" => "venues_ar.php",
    "المضيفات" => "hostesses_ar.php",
    "الضيافة" => "catring_ar.php",
    "التنسيق" => "decoration_ar.php",
    "الزهور" => "flowers_ar.php",
    "الوصيفات" => "bridesmaids_ar.php"
];

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتائج البحث</title>
      <link rel="stylesheet" href="style.css">
      <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
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
            <a href="about_ar.php">اعرف عنّا</a>
            <a href="contact_ar.php">تواصل معنا</a>
            
        </nav>
   
</header>

<section class="services-container-search">

<h2>نتائج البحث عن: <?php echo htmlspecialchars($q); ?></h2>

<?php

if ($q == '') {
    echo "<p>اكتب كلمة للبحث</p>";
} else {

    $found = false;

    foreach ($services as $name => $link) {

        if (mb_stripos($name, $q) !== false) {

            echo "
            <div class='service-card'>
                <h3>$name</h3>
                <a class='search-btn' href='$link'>مشاهدة الخيارات المتاحة</a>
            </div>
            ";

            $found = true;
        }
    }

    if (!$found) {
        echo "<p style='color:red;'>هذه الخدمة غير متاحة</p>";
    }
}

?>

</section>

</body>
</html>