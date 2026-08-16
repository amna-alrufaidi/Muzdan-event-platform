<?php
session_start();
include "db.php";

$user_name = $_SESSION['user_name'] ?? "Guest";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $booking_date = $_POST['booking_date'];
    $provider_id = $_POST['provider_id'];

    $sql = "INSERT INTO bookings (user_name, provider_id, booking_date)
            VALUES ('$user_name','$provider_id','$booking_date')";

    if ($conn->query($sql)) {

        // 🔥 أهم سطر (نجيب رقم الحجز)
        $booking_id = $conn->insert_id;

        // 🔥 نرسله لصفحة الدفع
        header("Location: payment.php?booking_id=$booking_id");
        exit();

    } else {
        echo "Booking error";
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muzdan</title>

    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
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

/* Available */
.available{
    background:#F3D6E0;
    color:#752E49;
}

/* Unavailable */
.unavailable{
    background:#E5E5E5;
    color:#999;
    cursor:not-allowed;
}

/* Selected */
.selected{
    background:#B56480 !important;
    color:white !important;
}

/* Legend */
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
    background: #c3678a;
    width: 15%;
    text-align: center;
    color:white;
    border-radius:8px;
    padding: 10px;
    justify-content: center;
}

.container{
    width:420px;
    max-width:95%;
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

<!-- ===== Header ===== -->

<header>

    <div class="logo-section">
        <img src="logo.jpg" alt="MUZDAN Logo">
        <h1>Muzdan</h1>
    </div>

    <nav>
        <a href="home_ar.php">Home</a>
        <a href="services_ar.php">Services</a>
        <a href="about_ar.php">About Us</a>
        <a href="contact_ar.php">Contact Us</a>
    </nav>

</header>

<!-- ===== BOOKING CALENDAR ===== -->

<div class="container">

    <div class="header">
        <button onclick="prevMonth()">➡</button>
        <h3 id="monthTitle"></h3>
        <button onclick="nextMonth()">⬅</button>
    </div>

    <div class="days" id="calendar"></div>

    <div class="legend">
        <div>Available <span class="box green"></span></div>
        <div>Unavailable <span class="box gray"></span></div>
        <div>Selected Day <span class="box blue"></span></div>
    </div>

    <br>

  <form method="POST">

<input type="hidden" name="booking_date" id="booking_date">

<!-- Provider ID (comes from page or URL) -->
<input type="hidden" name="provider_id" value="6">

<button type="submit" class="reserve-btn">Book</button>

</form>

</div>

<!-- ===== FOOTER ===== -->

<footer>
     © 2026 Muzdan | All Rights Reserved
</footer>

<!-- ===== SCRIPT ===== -->

<script>

let date = new Date();
let selectedDay = null;

// Unavailable days
let unavailableDays = [3, 4, 10, 15, 20, 25];

function renderCalendar(){

    const calendar = document.getElementById("calendar");
    calendar.innerHTML = "";

    const year = date.getFullYear();
    const month = date.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    document.getElementById("monthTitle").innerText =
        date.toLocaleDateString('en', {month:'long', year:'numeric'});

    for(let i = 0; i < firstDay; i++){
        calendar.appendChild(document.createElement("div"));
    }for(let i = 1; i <= daysInMonth; i++){

        let div = document.createElement("div");
        div.classList.add("day");

        if(unavailableDays.includes(i)){
            div.classList.add("unavailable");
        }else{
            div.classList.add("available");
            div.onclick = () => selectDay(div, i);
        }

        div.innerText = i;
        calendar.appendChild(div);
    }
}

function selectDay(el, day){

    document.querySelectorAll(".day")
    .forEach(d => d.classList.remove("selected"));

    el.classList.add("selected");

    selectedDay = day;

    document.getElementById("booking_date").value =
        date.getFullYear() + "-" + (date.getMonth()+1) + "-" + day;
}

function prevMonth(){
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
}

function nextMonth(){
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
}

function book(){

    if(selectedDay){
        window.location.href = "payment_ar.php";
    }else{
        alert("Please select a day first!");
    }
}

renderCalendar();

</script>

</body>
</html>
