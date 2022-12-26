<?php

declare(strict_types=1);
require(__DIR__ . '/hotelFunctions.php');

$priceData = file_get_contents(__DIR__ . '/../pricing.json');
$priceData = json_decode($priceData, true);

$saunaPrice = $priceData['feature_prices']['sauna'];
$tourPrice = $priceData['feature_prices']['tour'];
$bedPrice = $priceData['feature_prices']['bed'];

session_start();

// $_POST['transferCode']
if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'])) {
    $status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);

    $room = $_POST['room'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    // $transferCode = $_POST['transferCode'];

    $featSauna = false;
    $featTour = false;
    $featBed = false;

    $status['totalCost'] = calcRoomPrice($room, $arrivalDate, $departureDate);

    if ($room === "budget") {
        $room = 1;
    } else if ($room === "standard") {
        $room = 2;
    } else if ($room === "luxury") {
        $room = 3;
    }

    if (isset($_POST['features'])) {
        $features = $_POST['features'];
        foreach ($features as $feature) {
            if ($feature === 'sauna') {
                $status['totalCost'] += $saunaPrice;
                $featSauna = true;
            }

            if ($feature === 'tour') {
                $status['totalCost'] += $tourPrice;
                $featTour = true;
            }

            if ($feature === 'bed') {
                $status['totalCost'] += $bedPrice;
                $featBed = true;
            }
        }
    }

    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $status['is_booking_available'] = true;
    }

    // if (isTransferCodeValid($transferCode, $status['totalCost'])) {
    //     $status['is_transferCode_valid'] = true;
    // }

    // if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
    //     book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
    //     cashInTransferCode($transferCode);
    // }

    if ($status['is_booking_available']) {
        $status['bookingUID'] = book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
        $status['is_transferCode_valid'] = true;
        $_SESSION['arrivalDate'] = $arrivalDate;
        $_SESSION['departureDate'] = $departureDate;
        $_SESSION['bookingUID'] = $status['bookingUID'];
        $_SESSION['room'] = $_POST['room'];
        $_SESSION['sauna'] = $featSauna;
        $_SESSION['tour'] = $featTour;
        $_SESSION['bed'] = $featBed;
        $_SESSION['totalCost'] = $status['totalCost'];
    }

    header('Content-type: application/json');
    echo json_encode($status);
}
