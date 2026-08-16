<?php
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ===== Provider Data =====
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $whatsapp = $_POST['whatsapp'];

    $service_type = $_POST['service_type'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $iban = $_POST['iban'];

    // ===== Image Upload =====
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

    // ===== Save provider =====
    $sql = "INSERT INTO providers 
    (name, phone, email, whatsapp, service_type, description, location, iban, logo, images)
    VALUES 
    ('$name','$phone','$email','$whatsapp','$service_type','$description','$location','$iban','$logo','$images_json')";

    if ($conn->query($sql)) {

        $message = "Saved successfully ✔️";

        $provider_id = $conn->insert_id;

        // ===== Packages =====
        $title1 = $_POST['package1_title'];
        $price1 = $_POST['package1_price'];

        $title2 = $_POST['package2_title'];
        $price2 = $_POST['package2_price'];

        $title3 = $_POST['package3_title'];
        $price3 = $_POST['package3_price'];

        $conn->query("INSERT INTO provider_packages (provider_id, title, price, description)
        VALUES ('$provider_id','$title1','$price1','')");

        $conn->query("INSERT INTO provider_packages (provider_id, title, price, description)
        VALUES ('$provider_id','$title2','$price2','')");

        $conn->query("INSERT INTO provider_packages (provider_id, title, price, description)
        VALUES ('$provider_id','$title3','$price3','')");

        // ===== Social Links =====
        $snapchat = $_POST['snapchat'];
        $instagram = $_POST['instagram'];
        $tiktok = $_POST['tiktok'];

        $conn->query("INSERT INTO social_links (provider_id, snapchat, instagram, tiktok)
        VALUES ('$provider_id','$snapchat','$instagram','$tiktok')");
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Provider Registration | Muzdan</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

<header>
    <div class="logo-section">
        <img src="logo.jpg" alt="MUZDAN Logo">
        <h1>Muzdan</h1>
    </div>
</header>

<div class="provider-form">

<h2>Service Provider Registration</h2>

<p style="color:green;font-weight:bold;">
<?php echo $message; ?>
</p>

<form method="POST" enctype="multipart/form-data">

<!-- Data -->
<label>Name</label>
<input type="text" name="name">

<label>Phone Number</label>
<input type="tel" name="phone">

<label>Email</label>
<input type="email" name="email">

<label>WhatsApp</label>
<input type="tel" name="whatsapp">

<!-- Social -->
<h3>Social Media Accounts</h3>

<label><input type="checkbox" onclick="toggleSocial('snap')"> Snapchat</label>
<input type="text" id="snap" name="snapchat" style="display:none;">

<label><input type="checkbox" onclick="toggleSocial('insta')"> Instagram</label>
<input type="text" id="insta" name="instagram" style="display:none;">

<label><input type="checkbox" onclick="toggleSocial('tiktok')"> TikTok</label>
<input type="text" id="tiktok" name="tiktok" style="display:none;">

<!-- Service -->
<h3>Service Details</h3>

<label>Service Type</label>
<select name="service_type">
    <option>Photography</option>
    <option>venues</option>
    <option>Hostesses</option>
    <option>Hospitality</option>
    <option>Coordination</option>
    <option>Flowers</option>
    <option>Bridesmaids</option>
</select>

<label>Service Description</label>
<textarea name="description" rows="4"></textarea>

<!-- Packages -->
<h3>Packages</h3>

<label>Package 1</label>
<input type="text" name="package1_title">
<input type="number" name="package1_price">

<label>Package 2</label>
<input type="text" name="package2_title">
<input type="number" name="package2_price">

<label>Package 3</label>
<input type="text" name="package3_title">
<input type="number" name="package3_price">

<!-- Location -->
<h3>Location</h3>
<input type="text" name="location">

<!-- Account -->
<h3>Bank Account</h3>
<input type="text" name="iban">

<!-- Images -->
<h3>Images</h3>

<label>Logo Image</label>
<input type="file" name="logo">

<label>Portfolio Images</label>
<input type="file" name="images[]" multiple>

<button type="submit">Save Data</button>

</form>

</div>

<footer>
© 2026 Muzdan | All Rights Reserved
</footer>

<script>
function toggleSocial(id){
    const input = document.getElementById(id);
    input.style.display = input.style.display === "none" ? "block" : "none";
}
</script>

</body>
</html>