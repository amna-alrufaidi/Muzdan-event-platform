<!DOCTYPE html> 
<html lang="ar" dir="rtl"> 
<head> 
    <meta charset="UTF-8"> 
    <title>نسيت كلمة المرور - مُـــزدان</title> 
    <link rel="stylesheet" href="style.css"> 
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
 
<!-- ===== Forgot Password ===== --> 
<section class="hero"> 
 
    <div class="hero-text" style="max-width:450px; margin:auto; text-align:center;"> 
 
        <h2>نسيت كلمة المرور</h2> 
 
        <p>أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين.</p> 
 
        <!-- الفورم --> 
        <form onsubmit="return sendLink(event)"> 
 
            <input type="email" 
                   id="email" 
                   placeholder="البريد الإلكتروني" 
                   required 
                   style="width:100%; padding:10px; margin:10px 0;"> 
 
            <button type="submit" class="register-btn" 
            style="width:50%; border:none; padding:12px; border-radius:8px; margin-bottom:50px"> 
                إرسال الرابط 
            </button> 
 
        </form> 
 
        <!-- رسالة النجاح --> 
        <p id="msg" style="color:green; margin-top:15px; display:none;"> 
            تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني. 
        </p> 
 
        <a href="login_ar.php" class="login-btn" 
        style="font-size:small; width:50%;  padding:12px; border-radius:8px; text-decoration:none;"> 
            العودة لتسجيل الدخول 
        </a> 
 
    </div> 
 
</section> 
 
<!-- ===== Support ===== --> 
<section class="features"> 
    <div class="card" style="text-align:center;"> 
        <h3>الدعم الفني</h3> 
        <p>إذا لم تستلم البريد، تواصل مع الدعم لحل المشكلة.</p> 
    </div> 
</section> 
 
<!-- ===== Footer ===== --> 
<footer> 
    © ٢٠٢٦ مُـــزدان | جميع الحقوق محفوظة 
</footer> 
 
<!-- ===== JavaScript ===== --> 
<script> 
function sendLink(event) { 
    event.preventDefault(); // يمنع إعادة تحميل الصفحة 
 
    let email = document.getElementById("email").value; 
    let msg = document.getElementById("msg"); 
 
    if (email.trim() === "") { 
        alert("اكتب البريد الإلكتروني أول"); 
        return false; 
    } 
 
    // هنا نعتبر أنه تم الإرسال 
    msg.style.display = "block"; 
 
    // تفريغ الحقل 
    document.getElementById("email").value = ""; 
 
    return false; 
} 
</script> 
 
</body> 
</html>