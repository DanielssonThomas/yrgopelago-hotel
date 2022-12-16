<?php
require(__DIR__ . '/PHP/hotelFunctions.php');
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

$dbh = connect('../hotel.db');
$stmt = $dbh->query('SELECT arrival_date, departure_date FROM bookings');
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($data as $arrivals) {
  echo $arrivals['arrival_date'];
}
print_r($data);

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'])) {
  $room = $_POST['room'];

  if ($room === "budget") {
    $room = 1;
  } else if ($room === "standard") {
    $room = 2;
  } else {
    $room = 3;
  }

  $arrivalDate = $_POST['arrivalDate'];
  $departureDate = $_POST['departureDate'];
  book($room, $arrivalDate, $departureDate);
}

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
  <form action="index.php" method="POST">
    <label for="rooms">Select room:</label>

    <select name="room">
      <option value="budget">Budget</option>
      <option value="standard">Standard</option>
      <option value="luxury">Luxury</option>
    </select>

    <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31">
    <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31">
    <button type="submit">SUBMIT</button>
  </form>

</body>

</html>