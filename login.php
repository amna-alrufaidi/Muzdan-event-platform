<?php
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Get user from database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        // Verify password (since it's hashed)
        if (password_verify($password, $user['password'])) {

            // Create login session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Redirect to dashboard (or any page you want)
            header("Location: services.php");
            exit();

        } else {
            $message = "❌ Incorrect password";
        }

    } else {
        $message = "❌ Account not found";
    }
}
?>

<!DOCTYPE html> 
<html lang="en" dir="ltr"> 
<head> 
 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
 
    <title>Login - Muzdan</title> 
 
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
        </nav> 
 
    </header> 
 
    <!-- ===== Login Form ===== --> 
 
    <section class="features"> 
 
        <div class="card" style="max-width:450px; margin:auto; text-align:center;"> 
 
            <h3>Login</h3> 
 
            <p style="margin-bottom:20px;"> 
               Log in to access your account and services!
               <?php if (!empty($message)) { ?>
    <p style="color:red; font-weight:bold;">
        <?php echo $message; ?>
    </p>
<?php } ?>
            </p> 
 
            <form method="POST"> 
 
                <input type="email" 
                       name="email" 
                       placeholder="Email Address" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
 
                <input type="password" 
                       name="password" 
                       placeholder="Password" 
                       required 
                       style="width:100%; padding:10px; margin:10px 0;"> 
              
                <button type="submit" 
                        class="register-btn" 
                        style="width:50%; border:none; padding:12px; border-radius:8px;"> 
 
                    Login 
 
                </button> 
            </form> 
 
            <p style="margin-top:15px;"> 
 
                <a href="forgetpass.php"> 
                    Forgot Password? 
                </a> 
 
            </p> 
 
            <p style="margin-top:10px;"> 
 
                Don't have an account? 
 
                <a href="register.php"> 
                    Create Account 
                </a> 

 
            </p> 
   <a href="loginAdmin.php"> 
             Admin
                </a> 
        </div> 
 
    </section> 
 
    <!-- ===== Footer ===== --> 
 
    <footer> 
        © 2026 Muzdan | All Rights Reserved 
    </footer> 
 
</body> 
</html>