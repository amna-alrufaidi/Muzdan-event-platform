<?php
include "db.php";
session_start();

$booking_id = $_GET['booking_id'];
$user_name = $_SESSION['user_name'] ?? "Guest";

// نجيب بيانات الحجز (عشان السعر لاحقًا)
$sql = "SELECT * FROM bookings WHERE id='$booking_id'";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();

// حفظ الدفع
$conn->query("
INSERT INTO payments (booking_id, user_name, amount, payment_method, status)
VALUES ('$booking_id','$user_name','100','manual','paid')
");

// تحديث الحجز
$conn->query("
UPDATE bookings SET status='paid' WHERE id='$booking_id'
");

echo "OK";
?>