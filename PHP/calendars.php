<?php

require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

$dates = $dbh->query('SELECT room_id, arrival_date, departure_date FROM bookings');
$data = $dates->fetchAll(PDO::FETCH_ASSOC);

$budgetEvents = array();
$StandardEvents = array();
$luxuryEvents = array();


foreach ($data as $room) {
    if ($room['room_id'] === 1) {
        $budgetEvents[] = array(
            'start' => $room['arrival_date'],
            'end' => $room['departure_date'],
            'mask' => true,
        );
    }

    if ($room['room_id'] === 2) {
        $StandardEvents[] = array(
            'start' => $room['arrival_date'],
            'end' => $room['departure_date'],
            'mask' => true,
        );
    }

    if ($room['room_id'] === 3) {
        $luxuryEvents[] = array(
            'start' => $room['arrival_date'],
            'end' => $room['departure_date'],
            'mask' => true,
        );
    }
}

$budgetCalendar = new Calendar;
$budgetCalendar->addEvents($budgetEvents);

$standardCalendar = new Calendar;
$standardCalendar->addEvents($StandardEvents);

$luxuryCalendar = new Calendar;
$luxuryCalendar->addEvents($luxuryEvents);

$budgetCalendar->useMondayStartingDate();
$standardCalendar->useMondayStartingDate();
$luxuryCalendar->useMondayStartingDate();

echo $budgetCalendar->display(date('2023-01-01'));
echo $standardCalendar->display(date('2023-01-01'));
echo $luxuryCalendar->display(date('2023-01-01'));
