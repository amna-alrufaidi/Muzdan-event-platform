<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_name'])){
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

$provider_id = $_POST['provider_id'];
$service_id = $_POST['service_id'];
$message = $_POST['message'];

$conn->query("
INSERT INTO messages 
(user_name, provider_id, service_id, message, message_type, status)
VALUES 
('$user_name', '$provider_id', '$service_id', '$message', 'provider', 'new')
");

header("Location: contact2_ar.php");
exit();
?>