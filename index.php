<?php
require(__DIR__ . '/PHP/hotelFunctions.php');
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

$roomOneCalendar = (new Calendar);
$roomTwoCalendar = (new Calendar);
echo $roomOneCalendar->draw(date('2023-01-01')) . $roomTwoCalendar->draw(date('2023-01-01'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/global.css" />
  <link rel="stylesheet" href="CSS/typography.css" />
  <title>Christmas assignment</title>
</head>

<body>
  <h1>Hotell adlon</h1>

  <form action="">
    <label for="rooms">Select room:</label>

    <select name="rooms" id="">
      <option value="budget">Budget</option>
      <option value="standard">Standard</option>
      <option value="luxury">Luxury</option>
    </select>

    <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31">
    <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31">
  </form>

</body>

</html>