<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $account_type = $_POST['account_type'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // التحقق من كلمة المرور
    if ($password != $confirm_password) {
        $message = "❌ Passwords do not match";
    } else {

        // تشفير كلمة المرور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // إدخال البيانات في قاعدة البيانات
        $sql = "INSERT INTO users (name, email, phone, account_type, password)
                VALUES ('$fullname', '$email', '$phone', '$account_type', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            $message = "✅ Account created successfully";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html> 
<html lang="en" dir="ltr"> 
<head> 
 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>Sign Up - Muzdan</title> 
 
    <link rel="stylesheet" href="style.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
 
<body> 
 
    <!-- ===== Header ===== --> 
 
    <header> 
 
        <div class="logo-section"> 
            <img src="logo.jpg" alt="MUZDAN Logo"> 
            <h1>Muzdan</h1> 
        </div> 
 
        <nav> 
            <a href="home.php">Home</a> 
            <a href="about.php">About Us</a> 
            <a href="contact.php">Contact Us</a> 
            <a href="login.php">Login</a> 
        </nav> 
 
    </header> 
 
    <!-- ===== Register Form ===== --> 
 
    <section class="features"> 
 
        <div class="card" style="max-width:450px; margin:auto; text-align:center;"> 
 
            <h3>Create Account</h3> 
 
            <p style="margin-bottom:20px;"> 
                Create your account to access all Muzdan services 
                        <?php if (!empty($message)) { ?>
    <p style="color:red; font-weight:bold;">
        <?php echo $message; ?>
    </p>
<?php } ?>
            </p> 
 
            <form method="POST">
 
                <input type="text" 
                       name="fullname" 
                       placeholder="Full Name" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="email" 
                       name="email" 
                       placeholder="Email Address" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="tel" 
                       name="phone" 
                       placeholder="Phone Number" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <select name="account_type" 
                        required 
                        style="width:100%; padding:10px; margin:10px 0;"> 
 
                    <option value="">Account Type</option> 
                    <option value="user">User</option> 
                    <option value="provider">Service Provider</option> 
 
                </select> 
 
                <input type="password" 
                       name="password" 
                       placeholder="Password" 
                       required 
                       minlength="8" 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="password" 
                       name="confirm_password" 
                       placeholder="Confirm Password" 
                       required 
                       minlength="8" 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <button type="submit" 
                        class="register-btn" 
                         style="width:50%; border:none; padding:12px; border-radius:8px;"> 
 
                    Sign Up 
 
                </button> 
 
            </form> 
 
            <p style="margin-top:15px;"> 
 
                Already have an account? 
 
                <a href="login.php"> 
                    Login 
                </a> 
 
            </p> 
 
        </div> 
 
    </section> 
 
    <!-- ===== Footer ===== --> 
 
    <footer> 
        © 2026 Muzdan | All Rights Reserved 
    </footer> 
 
</body> 
</html>