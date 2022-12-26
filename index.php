<?php
require(__DIR__ . '/PHP/hotelFunctions.php');

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
  <link rel="stylesheet" href="CSS/footer.css" />

  <title>Christmas assignment</title>
</head>

<body>
  <?php
  require(__DIR__ . '/PHP/header-booking.php');
  require(__DIR__ . '/PHP/main-hotells.php');
  require(__DIR__ . '/PHP/footer.php');
  ?>
  <script src="JS/script.js"></script>
  <script src="JS/booking.js"></script>
  <script src="JS/calendar.js"></script>
  <script src="JS/booking-search.js"></script>

</body>

</html>