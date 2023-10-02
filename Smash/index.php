<?php
include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Court Badminton Reservation System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #FF6600, #FFFFFF);
        }

        /* Container Styles */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styles */
        header {
            text-align: center;
            padding: 20px 0;
        }

        h1 {
            margin: 0;
            font-size: 32px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .icon {
            font-size: 24px;
            margin: 10px;
        }

        /* Reservation Section Styles */
        .reservation-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .reservation-section h2 {
            font-size: 28px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
        }

        .reservation-section p {
            font-size: 18px;
            color: #666;
        }

        /* Slideshow Styles */
        .slideshow-container {
            position: relative;
        }

        .slideshow-image {
            display: none;
            width: 100%;
            height: 70%;
        }

        /* Slideshow Animation */
        .fade {
            animation: fade 3s linear infinite;
        }

        @keyframes fade {
            0% { opacity: 0; }
            20% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Details Section Styles */
        .details-section {
            text-align: center;
            margin-top: 30px;
        }

        .details-section h3 {
            font-size: 24px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
        }

        .details-section p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Court Badminton Reservation System</h1>
            <div>
                <i class="fas fa-calendar-alt icon"></i>
                <span id="date"></span>
                <i class="fas fa-clock icon"></i>
                <span id="time"></span>
            </div>
        </div>
    </header>
    <main>
        <section class="reservation-section">
            <div class="container">
                <marquee scrollamount="15"><h2>Reserve a Badminton Court</h2></marquee>
                <p>Make your court reservation today!</p>
            </div>
        </section>

        <section class="image-section">
            <div class="container slideshow-container">
                <img class="slideshow-image fade" src="image/1.jpg" alt="Badminton Court" />
                <img class="slideshow-image fade" src="image/4.jpg" alt="Badminton Court" />
                <img class="slideshow-image fade" src="image/3.jpg" alt="Badminton Court" />
            </div>
        </section>

        <section class="details-section">
            <div class="container">
                <h3>Operating Hours:</h3>
                <p><strong>Weekdays:</strong> 8am - 11pm</p>
                <p><strong>Weekends/Public Holidays:</strong> 8am - 10pm</p>

                <h3>Booking Information:</h3>
                <p>Booking may be made in person at the Sports Counter or by telephone during operation hours at: +603 2011 9188 </p>
                <p>Booking has to be made up to three (3) days in advance.</p>
            </div>
        </section>
    </main>

    <script>
        // Slideshow JavaScript
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var slides = document.getElementsByClassName("slideshow-image");
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1; }

            slides[slideIndex - 1].style.display = "block";

            setTimeout(showSlides, 3000); // Change slide every 3 seconds
        }

        // Time Update JavaScript
        function updateTime() {
            var dateElement = document.getElementById('date');
            var timeElement = document.getElementById('time');

            var now = new Date();
            var date = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
            var time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false });

            dateElement.textContent = date;
            timeElement.textContent = time;
        }

        setInterval(updateTime, 1000); // Update time every second
    </script>
</body>
</html>

<?php
include 'footer.php';
?>
