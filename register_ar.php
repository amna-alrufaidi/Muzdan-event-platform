<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // التحقق من كلمة المرور
    if ($password != $confirm_password) {
        $message = "❌ كلمة المرور غير متطابقة";
    } else {

        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // إدخال البيانات في قاعدة البيانات
        $sql = "INSERT INTO users (name, email, phone, password)
                VALUES ('$fullname', '$email', '$phone', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = "✅ تم إنشاء الحساب بنجاح
            اذهب لتسجيل الدخول الأن!";
        } else {
            $message = "❌ خطأ: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html> 
<html lang="ar" dir="rtl"> 
<head> 
 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>إنشاء حساب - مُـــزدان</title> 
 
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
            <a href="home_ar.php">الرئيسية</a> 
            <a href="about_ar.php">اعرف عنّا</a> 
            <a href="contact_ar.php">تواصل معنا</a> 
            <a href="login_ar.php">تسجيل الدخول</a> 
        </nav> 
 
    </header> 
 
    <!-- ===== Register Form ===== --> 
 
    <section class="features"> 
 
        <div class="card" style="max-width:450px; margin:auto; text-align:center;"> 
 
            <h3>إنشاء حساب</h3> 
 
            <p style="margin-bottom:20px;"> 
                أنشئ حسابك للوصول إلى جميع خدمات مُـــزدان 
                <?php if (!empty($message)) { ?>
    <p style="color:red; font-weight:bold;">
        <?php echo $message; ?>
    </p>
<?php } ?>
            </p> 
 
            <form method="POST">
 
                <input type="text" 
                       name="fullname" 
                       placeholder="الاسم الكامل" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="email" 
                       name="email" 
                       placeholder="البريد الإلكتروني" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="tel" 
                       name="phone" 
                       placeholder="رقم الجوال" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
               
 
                <input type="password" 
                       name="password" 
                       placeholder="كلمة المرور" 
                       required 
                       minlength="8" 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="password" 
                       name="confirm_password" 
                       placeholder="تأكيد كلمة المرور" 
                       required 
                       minlength="8" 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <button type="submit" 
                        class="register-btn" 
                         style="width:50%; border:none; padding:12px; border-radius:8px;"> 
 
                    إنشاء حساب 
 
                </button> 
 
            </form> 
 
            <p style="margin-top:15px;"> 
 
                لديك حساب بالفعل؟ 
 
                <a href="login_ar.php"> 
                    تسجيل الدخول 
                </a> 
 
            </p> 
 
        </div> 
 
    </section> 
 
    <!-- ===== Footer ===== --> 
 
    <footer> 
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة 
    </footer> 
 
</body> 
</html>