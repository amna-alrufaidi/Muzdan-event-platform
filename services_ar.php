<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمات</title>
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
    <form action="search_ar.php" method="GET">
    <input type="text" name="q" placeholder="ابحث عن خدمة" class="search-box">
     </form>
        <nav>
            <a href="home2_ar.php">الرئيسية</a>
            <a href="services_ar.php">الخدمات</a>
            <a href="my_bookings_ar.php">حجوزاتي</a>
            <a href="about2_ar.php">اعرف عنّا</a>
            <a href="contact2_ar.php">تواصل معنا</a>
           
        </nav>

    </header>

    <!-- ===== Hero Section ===== -->

    <section class="services-container">

    <div class="service-card">

        <h2>الخدمات</h2>
        <div class="filter-container">

    <select id="serviceFilter">
        <option value="all">جميع الخدمات</option>
        <option value="photography">التصوير</option>
        <option value="venues">القاعات</option>
        <option value="hostesses">المضيفات</option>
        <option value="flowers">الزهور</option>
        <option value="catring">الضيافة</option>
        <option value="decoration">التنسيق</option>
        <option value="bridesmaids">الوصيفات</option>
    </select>

    <button onclick="filterServices()" class="filter-btn">
        تطبيق الفلتر
    </button>

</div>

       <div class="services-container">

            <div class="service-card" data-service="photography">
                <h3>التصوير</h3>
                <div class="buttons-service">
                    <a href="photography_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="venues">
                <h3>القاعات</h3>
                <div class="buttons-service">
                    <a href="venues_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="hostesses">
                <h3>المُضيفات</h3>
                <div class="buttons-service">
                    <a href="hostesses_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="catring">
                <h3>الضيافة</h3>
                <div class="buttons-service">
                    <a href="catring_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="decoration">
                <h3>التنسيق</h3>
                <div class="buttons-service">
                    <a href="decoration_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="flowers">
                <h3>الزهور</h3>
                <div class="buttons-service">
                    <a href="flowers_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="bridesmaids">
                <h3>الوصيفات</h3>
                <div class="buttons-service">
                    <a href="bridesmaids_ar.php" class="service-btn">
                        مشاهدة الخيارات المتاحة
                    </a>
                </div>
            </div>

        </div>

   </div>

</section>


    <!-- ===== Footer ===== -->

    <footer>
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة
    </footer>

    <script>

function filterServices() {

    let selected =
        document.getElementById("serviceFilter").value;

    let cards =
        document.querySelectorAll(".service-card[data-service]");

    cards.forEach(card => {

        let service =
            card.dataset.service;

        if(selected === "all") {
            card.style.display = "";
        }
        else if(service === selected) {
            card.style.display = "";
        }
        else {
            card.style.display = "none";
        }

    });

}

</script>
</body>
</html>