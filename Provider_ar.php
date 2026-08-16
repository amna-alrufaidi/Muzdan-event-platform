<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ===== بيانات مقدم الخدمة =====
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $service_type = $_POST['service_type'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $iban = $_POST['iban'];

    // ===== رفع الصور =====
    $logo = "";

if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {

    $logo = $_FILES['logo']['name'];
    $logo_tmp = $_FILES['logo']['tmp_name'];

    move_uploaded_file($logo_tmp, "uploads/" . $logo);
}

    $images_array = [];

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['name'] as $key => $img_name) {
            $tmp = $_FILES['images']['tmp_name'][$key];
            $path = "uploads/" . $img_name;
            move_uploaded_file($tmp, $path);
            $images_array[] = $img_name;
        }
    }

    $images_json = json_encode($images_array);

    // ===== حفظ provider =====
    $sql = "INSERT INTO providers 
    (name, phone, email, password, service_type, description, location, iban, logo, images, status)
    VALUES 
    ('$name','$phone','$email','$password','$service_type','$description','$location','$iban','$logo','$images_json', 'pending')";

    if ($conn->query($sql)) {

    $provider_id = $conn->insert_id;
  
    // ===== الباقات =====

if(isset($_POST['service_title'])){

    foreach($_POST['service_title'] as $index => $title){

        $price = $_POST['service_price'][$index];

        // تجاهل الحقول الفارغة
        if(trim($title) == "" || trim($price) == ""){
            continue;
        }

        $conn->query("
        INSERT INTO provider_packages
        (provider_id, title, price, description)
        VALUES
        ('$provider_id','$title','$price','')
        ");
   
    }

}

        // ===== السوشيال =====
        $snapchat = $_POST['snapchat'];
        $instagram = $_POST['instagram'];
        $tiktok = $_POST['tiktok'];

        $conn->query("INSERT INTO social_links (provider_id, snapchat, instagram, tiktok)
        VALUES ('$provider_id','$snapchat','$instagram','$tiktok')");
      // حفظ الجلسة
    $_SESSION['provider_id'] = $provider_id;
    $_SESSION['provider_name'] = $name;

    // تحويل مباشر للوحة التحكم
    header("Location: provider_dashboard_ar.php");
    exit();
    }
   
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>تسجيل مقدم خدمة | مُـــزدان</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

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

<div class="provider-form">

<h2>تسجيل مقدم الخدمة</h2>

<p style="color:green;font-weight:bold;">
<?php echo $message; ?>
</p>

<form method="POST" enctype="multipart/form-data">

<!-- بيانات -->
<label>الاسم</label>
<input type="text" name="name">

<label>رقم الجوال</label>
<input type="tel" name="phone">

<label>البريد الإلكتروني</label>
<input type="email" name="email">

<label>كلمة المرور</label>
<input type="password" name="password" required>


<!-- سوشيال -->
<h3>حسابات التواصل الاجتماعي</h3>

<label><input type="checkbox" onclick="toggleSocial('snap')"> سناب شات</label>
<input type="text" id="snap" name="snapchat" style="display:none;">

<label><input type="checkbox" onclick="toggleSocial('insta')"> إنستغرام</label>
<input type="text" id="insta" name="instagram" style="display:none;">

<label><input type="checkbox" onclick="toggleSocial('tiktok')"> تيك توك</label>
<input type="text" id="tiktok" name="tiktok" style="display:none;">

<!-- الخدمة -->
<h3>بيانات الخدمة</h3>

<label>نوع الخدمة</label>
<select name="service_type">
    <option>التصوير</option>
    <option>القاعات</option>
    <option>المُضِيفات</option>
    <option>الضيافة</option>
    <option>التنسيق</option>
    <option>الزهور</option>
    <option>الوصيفات</option>
</select>

<label>وصف الخدمة</label>
<textarea name="description" rows="4"></textarea>

<!-- الباقات -->
<h3>الخدمات والأسعار</h3>

<label>عدد الخدمات</label>

<select id="serviceCount" onchange="generateServices()">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
</select>

<div id="servicesContainer"></div>

<!-- الموقع -->
<h3>الموقع</h3>
<input type="text" name="location">

<!-- الحساب -->
<h3>الحساب البنكي</h3>
<input type="text" name="iban">

<!-- الصور -->
<h3>الصور</h3>

<label>صورة الشعار</label>
<input type="file" name="logo">

<label>صور الأعمال</label>
<input type="file" name="images[]" multiple>

<button type="submit">حفظ البيانات</button>

</form>

</div>

<footer>
© 2026 مُـــزدان | جميع الحقوق محفوظة
</footer>

<script>
function toggleSocial(id){
    const input = document.getElementById(id);
    input.style.display = input.style.display === "none" ? "block" : "none";
}
</script>
<script>

function generateServices() {

    let count =
        document.getElementById("serviceCount").value;

    let container =
        document.getElementById("servicesContainer");

    container.innerHTML = "";

    for(let i = 1; i <= count; i++) {

        container.innerHTML += `

        <label>اسم الخدمة ${i}</label>

        <input type="text"
               name="service_title[]">

        <label>السعر</label>

        <input type="number"
               name="service_price[]">

        <br><br>

        `;

    }

}

generateServices();

</script>

</body>
</html>