<?php
$q = trim($_GET['q'] ?? '');

$services = [
    "Photography" => "photography.php",
    "Halls" => "venues.php",
    "Hostesses" => "hostesses.php",
    "Catering" => "catring.php",
    "Decoration" => "decoration.php",
    "Flowers" => "flowers.php",
    "Bridesmaids" => "bridesmaids.php"
];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
      <link rel="stylesheet" href="style.css">
      <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>

<header>
     <div class="logo-section">
            <img src="logo.jpg" alt="MUZDAN Logo">
            <h1>Muzdan</h1>
        </div>
        <nav>
            <a href="home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            
        </nav>
   
</header>

<section class="services-container-search">

<h2>Search results for: <?php echo htmlspecialchars($q); ?></h2>

<?php

if ($q == '') {
    echo "<p>Type a keyword to search</p>";
} else {

    $found = false;

    foreach ($services as $name => $link) {

        if (mb_stripos($name, $q) !== false) {

            echo "
            <div class='service-card'>
                <h3>$name</h3>
                <a class='search-btn' href='$link'>View Available Options</a>
            </div>
            ";

            $found = true;
        }
    }

    if (!$found) {
        echo "<p style='color:red;'>Service not available</p>";
    }
}

?>

</section>

</body>
</html>