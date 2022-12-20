<?php

require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar as Calendar;

$BudgetBookings = $dbh->query('SELECT arrival_date, departure_date FROM bookings WHERE room_id = 1');
$StandardBookings = $dbh->query('SELECT arrival_date, departure_date FROM bookings WHERE room_id = 2');
$LuxuryBookings = $dbh->query('SELECT arrival_date, departure_date FROM bookings WHERE room_id = 3');

$BudgetBookedDates = $BudgetBookings->fetchAll(PDO::FETCH_ASSOC);
$StandardBookedDates = $StandardBookings->fetchAll(PDO::FETCH_ASSOC);
$LuxuryBookedDates = $LuxuryBookings->fetchAll(PDO::FETCH_ASSOC);

$budgetEvents = array();
$StandardEvents = array();

foreach ($BudgetBookedDates as $date) {
    $budgetEvents[] = array(
        'start' => $date['arrival_date'],
        'end' => $date['departure_date'],
        'mask' => true,
    );
}
foreach ($StandardEvents as $date) {
    $StandardEvents[] = array(
        'start' => $date['arrival_date'],
        'end' => $date['departure_date'],
        'mask' => true,
    );
}


$budgetCalendar = (new Calendar);
$budgetCalendar->addTableClasses('calendar-table');
$budgetCalendar->addEvents($budgetEvents);
$standardCalendar = new Calendar;
$luxuryCalendar = new Calendar;

$budgetCalendar->useMondayStartingDate();
echo $budgetCalendar->display(date('2023-01-01'));
