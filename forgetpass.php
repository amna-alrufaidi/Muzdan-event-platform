<!DOCTYPE html> 
<html lang="en" dir="ltr"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Forgot Password - Muzdan</title> 
    <link rel="stylesheet" href="style.css"> 
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
 
<!-- ===== Forgot Password ===== --> 
<section class="hero"> 
 
    <div class="hero-text" style="max-width:450px; margin:auto; text-align:center;"> 
 
        <h2>Forgot Password</h2> 
 
        <p>Enter your email and we will send you a reset link.</p> 
 
        <!-- form --> 
        <form onsubmit="return sendLink(event)"> 
 
            <input type="email" 
                   id="email" 
                   placeholder="Email Address" 
                   required 
                   style="width:100%; padding:10px; margin:10px 0;"> 
 
            <button type="submit" class="register-btn" 
            style="width:50%; border:none; padding:12px; border-radius:8px; margin-bottom:50px"> 
                Send Link 
            </button> 
 
        </form> 
 
        <!-- success message --> 
        <p id="msg" style="color:green; margin-top:15px; display:none;"> 
            A password reset link has been sent to your email. 
        </p> 
 
        <a href="login.php" class="login-btn" 
        style="font-size:small; width:50%;  padding:12px; border-radius:8px; text-decoration:none;"> 
            Back to Login 
        </a> 
 
    </div> 
 
</section> 
 
<!-- ===== Support ===== --> 
<section class="features"> 
    <div class="card" style="text-align:center;"> 
        <h3>Support</h3> 
        <p>If you did not receive the email, contact support for help.</p> 
    </div> 
</section> 
 
<!-- ===== Footer ===== --> 
<footer> 
    © 2026 Muzdan | All Rights Reserved 
</footer> 
 
<!-- ===== JavaScript ===== --> 
<script> 
function sendLink(event) { 
    event.preventDefault(); // prevent page reload 
 
    let email = document.getElementById("email").value; 
    let msg = document.getElementById("msg"); 
 
    if (email.trim() === "") { 
        alert("Please enter your email first"); 
        return false; 
    } 
 
    // simulate sending 
    msg.style.display = "block"; 
 
    // clear input 
    document.getElementById("email").value = ""; 
 
    return false; 
} 
</script> 
 
</body> 
</html>