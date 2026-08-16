<?php
include "db.php";

$message_id = $_POST['message_id'];
$reply = $_POST['reply'];

$conn->query("
UPDATE messages
SET reply='$reply', status='replied'
WHERE id='$message_id'
");

header("Location: provider_dashboard_ar.php");
exit();
?>