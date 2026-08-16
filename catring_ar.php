<?php

$conn = mysqli_connect("localhost","root","","muzdan");


$rating = $_GET['rating'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$sql = "

SELECT DISTINCT
providers.*

FROM providers

LEFT JOIN provider_packages
ON providers.id = provider_packages.provider_id

LEFT JOIN reviews
ON providers.id = reviews.provider_id

WHERE providers.service_type='الضيافة'
AND status= 'approved'
";

if($max_price != ''){

    $sql .= "
    AND provider_packages.price <= '$max_price'
    ";
}

$sql .= "
GROUP BY providers.id
";

if($rating != ''){

    $sql .= "
    HAVING AVG(reviews.rating) >= '$rating'
    ";
}

$result = mysqli_query($conn,$sql);

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الضيافة</title>
      <link rel="stylesheet" href="style.css">
      <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
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
            <a href="about2_ar.php">اعرف عنّا</a>
            <a href="contact2_ar.php">تواصل معنا</a>
           
        </nav>

    </header>

    <!-- ===== Hero Section ===== -->

    <section class="services-container">

    <div class="service-card">

        <h2>الضيافة</h2>
         <form method="GET" class="filter-container">

    <select name="rating">

        <option value="">
            جميع التقييمات
        </option>

        <option value="5">
            5 نجوم
        </option>

        <option value="4">
            4 نجوم فأعلى
        </option>

        <option value="3">
            3 نجوم فأعلى
        </option>

        <option value="2">
            نجمتان فأعلى
        </option>

    </select>

    <br><br>

    <input
    type="number"
    name="max_price"
    placeholder="أقصى سعر">

    

    <button
    type="submit"
    class="filter-btn">

        تطبيق الفلاتر

    </button>

</form>

<br>

        <div class="services-container">

            <?php while($provider = mysqli_fetch_assoc($result)) { ?>

<div class="service-card">

    <h3>
        <?php echo $provider['name']; ?>
    </h3>

    <div class="buttons-service">

        <a
        href="service_details_ar.php?id=<?php echo $provider['id']; ?>"
        class="service-btn">

            عرض تفاصيل الخدمة

        </a>

    </div>

</div>

<?php } ?>

            

        </div>

    </div>

</section>


    <!-- ===== Footer ===== -->

    <footer>
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة
    </footer>

</body>
</html>