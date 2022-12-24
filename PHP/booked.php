<?php
require(__DIR__ . '/hotelFunctions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/CSS/global.css" />
    <link rel="stylesheet" href="/CSS/typography.css" />
    <link rel="stylesheet" href="/CSS/header.css" />
    <link rel="stylesheet" href="/CSS/main-hotells.css" />
    <link rel="stylesheet" href="/CSS/booking.css" />
    <link rel="stylesheet" href="/CSS/booked.css" />

    <title>Christmas assignment</title>
</head>

<body>
    <?php
    require(__DIR__ . '/header.php');
    ?>
    <main>
        <section class="confirm-booking-section">
            <div class="booked-checkmark">
                <img src="../Images/SVG/check-mark.svg">
            </div>
            <section class="booked-contents">
                <div>
                    <h2>Booking confirmed!</h2>
                </div>
                <article>
                    <p>Your booking has been confirmed</p>
                </article>
            </section>
        </section>
    </main>
    <script src="/JS/script.js"></script>
    <script src="/JS/calendar.js"></script>

</body>

</html>