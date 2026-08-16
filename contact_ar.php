<?php
include "db.php";
session_start();

$user_name = $_SESSION['user_name'] ?? "زائر";

/* ===== جلب كل الرسائل ===== */
$messages = $conn->query("
SELECT m.*, p.name AS provider_name
FROM messages m
LEFT JOIN providers p ON m.provider_id = p.id
WHERE m.user_name='$user_name'
ORDER BY m.id DESC
");
/* ===== إرسال الرسالة ===== */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $message = $_POST['message'];

    if (!empty($message)) {

        $conn->query("
            INSERT INTO messages (user_name, message)
            VALUES ('$user_name', '$message')
        ");
    }

    header("Location: contact_ar.php?sent=1");
    exit();
}

/* ===== جلب آخر رد ===== */
$replyData = $conn->query("
    SELECT * FROM messages 
    WHERE user_name='$user_name'
    ORDER BY id DESC
    LIMIT 1
")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تواصل معنا - مُــزدان</title>

<link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg">
        <h1>مُـــزدان</h1>
    </div>

    <nav>
        <a href="home_ar.php">الرئيسية</a>
        <a href="about_ar.php">اعرف عنّا</a>
        <a href="contact_ar.php">تواصل معنا</a>
    </nav>
</header>

<section class="features">

<div class="card" style="max-width:500px;margin:auto;text-align:center;">

<h3>تواصل معنا</h3>

<?php if(isset($_GET['sent'])){ ?>
<p style="color:green;">✔ تم إرسال رسالتك بنجاح</p>
<?php } ?>

<form method="POST">

    <textarea name="message"
              placeholder="اكتب رسالتك"
              required
              style="width:100%;padding:10px;margin:10px 0;height:150px;"></textarea>

    <button type="submit"
            class="register-btn"
            style="width:50%;border:none;padding:12px;border-radius:8px;">
        إرسال
    </button>

</form>

<!-- ===== عرض رد الأدمن ===== -->
<?php if($replyData && $replyData['reply']){ ?>
    <div style="margin-top:20px;padding:10px;background:#f3f3f3;border-radius:10px;">
        <h4>الرد على اخر رسالة :</h4>
        <p style="color:green;"><?= $replyData['reply'] ?></p>
    </div>
<?php } ?>

<div style="margin-top:30px;text-align:right;">

<h3> جميع رسائلي</h3>

<?php while($m = $messages->fetch_assoc()){ ?>

<div style="background:#f9f9f9;padding:10px;margin:10px 0;border-radius:10px;">

    <p><b> الرسالة:</b> <?= $m['message'] ?></p>
     <p><b> المرسل اليه:</b><?= $m['provider_name'] ?? 'مزدان' ?></p>


    <p><b> الرد:</b> <?= $m['reply'] ?? 'لا يوجد رد حتى الآن' ?></p>

    <p><b> الحالة:</b> <?= $m['status'] ?? 'new' ?></p>

</div>

<?php } ?>

</div>
</div>

</section>

<footer>
© 2026 مُــزدان | جميع الحقوق محفوظة
</footer>

</body>
</html>