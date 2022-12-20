<?php
require(__DIR__ . '/PHP/hotelFunctions.php');
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'])) {
  $room = $_POST['room'];
  $arrivalDate = $_POST['arrivalDate'];
  $departureDate = $_POST['departureDate'];

  if ($room === "budget") {
    $room = 1;
  } else if ($room === "standard") {
    $room = 2;
  } else {
    $room = 3;
  }

  if ($arrivalDate == "" || $departureDate == "") {
    echo "You must enter arrival and departure dates";
  } else {
    book($room, $arrivalDate, $departureDate);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/global.css" />
  <link rel="stylesheet" href="CSS/typography.css" />
  <link rel="stylesheet" href="CSS/header.css" />
  <link rel="stylesheet" href="CSS/main-hotells.css" />
  <link rel="stylesheet" href="CSS/booking.css" />

  <title>Christmas assignment</title>
</head>

<body>
  <?php
  require(__DIR__ . '/PHP/header.php');
  require(__DIR__ . '/PHP/main-hotells.php');
  ?>

  <script src="JS/calendar.js"></script>
  <script src="JS/script.js"></script>
</body>

</html>