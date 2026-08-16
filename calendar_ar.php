<?php
session_start();
include "db.php";

$provider_id = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 0;
$package_id = isset($_GET['package_id']) ? intval($_GET['package_id']) : 0;
if($provider_id == 0){
    die("❌ خطأ: لم يتم تحديد مقدم الخدمة");
}

/* ===== جلب الأيام غير المتاحة ===== */
$unavailable = mysqli_query($conn,"
SELECT unavailable_date 
FROM unavailable_dates 
WHERE provider_id=$provider_id
");

$booked = mysqli_query($conn,"
SELECT booking_date 
FROM bookings 
WHERE provider_id=$provider_id
");

$unavailable_days = [];
$booked_days = [];

while($u = mysqli_fetch_assoc($unavailable)){
    $unavailable_days[] = $u['unavailable_date'];
}

while($b = mysqli_fetch_assoc($booked)){
    $booked_days[] = $b['booking_date'];
}

/* ===== الحجز ===== */
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($provider_id == 0){
    die("❌ لا يمكن إتمام الحجز بدون مقدم خدمة");
}

if(empty($_POST['booking_date'])){
    die("❌ يجب اختيار يوم أولاً");
}

    $date = $_POST['booking_date'];
    $package_id = $_POST['package_id'];
    $user_name = $_SESSION['user_name'] ?? "guest";

   mysqli_query($conn,"
INSERT INTO bookings (provider_id, package_id, user_name, booking_date)
VALUES ('$provider_id','$package_id','$user_name','$date')
");
    $booking_id = mysqli_insert_id($conn);
    header("Location: payment_ar.php?booking_id=$booking_id");
exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>التقويم</title>

<link rel="stylesheet" href="style.css">
 <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

<style>
    .days{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:8px;
}

.day{
    height:45px;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

/* متاح */
.available{
    background:#F3D6E0;
    color:#752E49;
}

/* غير متاح */
.unavailable{
    background:#E5E5E5;
    color:#999;
    cursor:not-allowed;
}

/* مختار */
.selected{
    background:#B56480 !important;
    color:white !important;
}

/* الليجند */
.legend{
    display:flex;
    justify-content:center;
    gap:15px;
    margin-top:15px;
    font-size:13px;
}

.box{
    width:10px;
    height:10px;
    border-radius:50%;
    display:inline-block;
    margin-left:5px;
}

.green{background:#F3D6E0;}
.gray{background:#E5E5E5;}
.blue{background:#B56480;}

.reserve-btn{
    text-decoration:none;
    background:#c3678a;
    width:10%;
    text-align:center;
    color:white;
    border-radius:8px;
    padding:10px;
    display:inline-block;
}

/* تحسين مهم */
.container{
    width:100%;
    max-width:420px;
    margin:50px auto;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    text-align:center;
}
</style>
</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg">
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
<button style="  display:inline-flex; width: 40px; padding:8px;" onclick="nextMonth()"><-</button>
<h3 style="display:inline-flex; margin-bottom:30px;" id="monthTitle"></h3>
    <button style="  display:inline-flex; width: 40px; padding:8px;" onclick="prevMonth()">-></button>

<div class="header">
    
</div>

<div class="days" id="calendar"></div>

<form method="POST">

<input type="hidden" name="booking_date" id="booking_date">
<input type="hidden" name="package_id" value="<?= $package_id ?>">

<button type="submit" class="register-btn" style="margin-top:20px;width:100%;">
حجز الآن
</button>

</form>

</div>

<script>

/* ===== بيانات من PHP ===== */
let unavailableDays = <?= json_encode($unavailable_days) ?>;
let bookedDays = <?= json_encode($booked_days) ?>;

let date = new Date();
let selected = null;

function renderCalendar(){

    let calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    let year = date.getFullYear();
    let month = date.getMonth();

    let firstDay = new Date(year, month, 1).getDay();
    let daysInMonth = new Date(year, month+1, 0).getDate();

    document.getElementById("monthTitle").innerText =
        date.toLocaleDateString('ar', {month:'long', year:'numeric'});

    for(let i=0;i<firstDay;i++){
        calendar.innerHTML += "<div></div>";
    }

    for(let i=1;i<=daysInMonth;i++){

        let div = document.createElement("div");
        div.classList.add("day");

        let fullDate = year + "-" + String(month + 1).padStart(2,'0') + "-" + String(i).padStart(2,'0');
        if(unavailableDays.includes(fullDate) || bookedDays.includes(fullDate)){
            div.classList.add("unavailable");
        }else{
            div.classList.add("available");

            div.onclick = () => {
                document.querySelectorAll(".day").forEach(d=>d.classList.remove("selected"));
                div.classList.add("selected");

                document.getElementById("booking_date").value = fullDate;
            }
        }

        div.innerText = i;
        calendar.appendChild(div);
    }
}

function prevMonth(){
    date.setMonth(date.getMonth()-1);
    renderCalendar();
}

function nextMonth(){
    date.setMonth(date.getMonth()+1);
    renderCalendar();
}

renderCalendar();

</script>
<footer>     
       © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة 
</footer>
</body>
</html>