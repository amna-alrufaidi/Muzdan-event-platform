<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
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

    <form action="search.php" method="GET">
    <input type="text" name="q" placeholder="Search for a service" class="search-box">
     </form>

        <nav>
            <a href="home.php">Home</a>
            <a href="services.php">Services</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact Us</a>
            <a href="filteing.php">Filter</a>
        </nav>

    </header>

    <!-- ===== Hero Section ===== -->

    <section class="services-container">

    <div class="service-card">

        <h2>Services</h2>

        <div class="filter-container">

    <select id="serviceFilter">
        <option value="all">All Services</option>
        <option value="photography">Photography</option>
        <option value="venues">Halls</option>
        <option value="hostesses">Hostesses</option>
        <option value="flowers">Flowers</option>
        <option value="catring">Catering</option>
        <option value="decoration">Decoration</option>
        <option value="bridesmaids">Bridesmaids</option>
    </select>

    <button onclick="filterServices()" class="filter-btn">
        Apply Filter
    </button>

</div>

       <div class="services-container">

            <div class="service-card" data-service="photography">
                <h3>Photography</h3>
                <div class="buttons-service">
                    <a href="photography.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="venues">
                <h3>Halls</h3>
                <div class="buttons-service">
                    <a href="venues.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="hostesses">
                <h3>Hostesses</h3>
                <div class="buttons-service">
                    <a href="hostesses.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="catring">
                <h3>Catering</h3>
                <div class="buttons-service">
                    <a href="catring.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="decoration">
                <h3>Decoration</h3>
                <div class="buttons-service">
                    <a href="decoration.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="flowers">
                <h3>Flowers</h3>
                <div class="buttons-service">
                    <a href="flowers.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

            <div class="service-card" data-service="bridesmaids">
                <h3>Bridesmaids</h3>
                <div class="buttons-service">
                    <a href="bridesmaids.php" class="service-btn">
                        View Available Options
                    </a>
                </div>
            </div>

        </div>

   </div>

</section>


    <!-- ===== Footer ===== -->

    <footer>© 2026 Muzdan | All Rights Reserved
    </footer>

    <script>

function filterServices() {

    let selected =
        document.getElementById("serviceFilter").value;

    let cards =
        document.querySelectorAll(".service-card[data-service]");

    cards.forEach(card => {

        let service =
            card.dataset.service;

        if(selected === "all") {
            card.style.display = "";
        }
        else if(service === selected) {
            card.style.display = "";
        }
        else {
            card.style.display = "none";
        }

    });

}

</script>
</body>
</html>