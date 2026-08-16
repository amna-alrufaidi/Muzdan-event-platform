<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    /* =========================
       1. البحث في users (عميل)
    ========================= */
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: services_ar.php");
            exit();
        } else {
            $message = "❌ كلمة المرور غير صحيحة";
        }

    } else {

        /* =========================
           2. البحث في providers
        ========================= */
        $sql2 = "SELECT * FROM providers WHERE email='$email'";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {

            $provider = $result2->fetch_assoc();

            if (password_verify($password, $provider['password'])) {

                $_SESSION['provider_id'] = $provider['id'];
                $_SESSION['provider_name'] = $provider['name'];

                header("Location: provider_dashboard_ar.php");
                exit();

            } else {
                $message = "❌ كلمة المرور غير صحيحة";
            }

        } else {
            $message = "❌ هذا الحساب غير موجود";
        }
    }
}
?>

<!DOCTYPE html> 
<html lang="ar" dir="rtl"> 
<head> 
 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>تسجيل الدخول - مُـــزدان</title> 
 
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
        </nav> 
 
    </header> 
 
    <!-- ===== Login Form ===== --> 
 
    <section class="features"> 
 
        <div class="card" style="max-width:450px; margin:auto; text-align:center;"> 
 
            <h3>تسجيل الدخول</h3> 
 
            <p style="margin-bottom:20px;"> 
               سجّل دخولك للوصول إلى حسابك وخدماتك!
               <?php if (!empty($message)) { ?>
    <p style="color:red; font-weight:bold;">
        <?php echo $message; ?>
    </p>
<?php } ?>

            </p> 
 
            <form method="POST"> 
 
                <input type="email" 
                       name="email" 
                       placeholder="البريد الإلكتروني" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="password" 
                       name="password" 
                       placeholder="كلمة المرور" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
              
                <button type="submit" 
                        class="register-btn" 
                        style="width:50%; border:none; padding:12px; border-radius:8px;"> 
 
                    تسجيل الدخول 
 
                </button> 
            </form> 
 
            <p style="margin-top:15px;"> 
 
                <a href="forgetpass_ar.php"> 
                    نسيت كلمة المرور؟ 
                </a> 
 
            </p> 
 
            <p style="margin-top:10px;"> 
 
                لا تملك حساب؟ 
 
                <a href="register_ar.php"> 
                    إنشاء حساب 
                </a> 
 
            </p> 
   <a href="loginAdmin_ar.php"> 
               لوحة المدير 
                </a> 
        </div> 
 
    </section> 
 
    <!-- ===== Footer ===== --> 
 
    <footer> 
        © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة 
    </footer> 
 
</body> 
</html>