<?php
require(__DIR__ . '/hotelFunctions.php');
session_start();

$sessionData = array(
    'arrivalDate' => $_SESSION['arrivalDate'],
    'departureDate' => $_SESSION['departureDate'],
    'bookingUID' => $_SESSION['bookingUID'],
    'room' => $_SESSION['room'],
    'totalCost' => $_SESSION['totalCost'],
    'sauna' => $_SESSION['sauna'],
    'tour' => $_SESSION['tour'],
    'bed' => $_SESSION['bed']
);

$bookedTemplate = file_get_contents(__DIR__ . '/../booking-confimation.json');
$bookedTemplate = json_decode($bookedTemplate, true);

$priceData = file_get_contents(__DIR__ . '/../pricing.json');
$priceData = json_decode($priceData, true);

$saunaPrice = $priceData['feature_prices']['sauna'];
$tourPrice = $priceData['feature_prices']['tour'];
$bedPrice = $priceData['feature_prices']['bed'];

$bookedTemplate['arrival_date'] = $sessionData['arrivalDate'];
$bookedTemplate['departure_date'] = $sessionData['departureDate'];
$bookedTemplate['total_cost'] = $sessionData['totalCost'];

if ($sessionData['sauna']) {
    $featureEntry = array('sauna' => $sessionData['sauna'], 'cost' => $saunaPrice);
    array_push($bookedTemplate['features'], $featureEntry);
}

if ($sessionData['tour']) {
    $featureEntry = array('Island_tour' => $sessionData['tour'], 'cost' => $tourPrice);
    array_push($bookedTemplate['features'], $featureEntry);
}

if ($sessionData['bed']) {
    $featureEntry = array('extra_bed' => $sessionData['bed'], 'cost' => $bedPrice);
    array_push($bookedTemplate['features'], $featureEntry);
}

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
                <article class="booked-uuid">
                    <h3>Here is you unique booking-ID. Enter it on our home page incase you loose your booking!</h3>
                    <p> <?= $sessionData['bookingUID'] ?></p>
                </article>
                <div>
                    <h2>Here is your JSON logbook entry:</h2>
                </div>
                <article class="booked-jsonData">
                    <pre>
                    <?= json_encode($bookedTemplate, JSON_PRETTY_PRINT) ?>
                    </pre>
                </article>
            </section>

        </section>
    </main>
    <script src="/JS/script.js"></script>
    <script src="/JS/calendar.js"></script>

</body>

</html>