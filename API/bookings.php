<?php

declare(strict_types=1);
require(__DIR__ . '/../PHP/hotelFunctions.php');

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'])) {
    $bookedTemplate = file_get_contents('../booking-confirmation.json');
    $bookedTemplate = json_decode($bookedTemplate, true);

    $priceData = file_get_contents(__DIR__ . '/../pricing.json');
    $priceData = json_decode($priceData, true);

    $saunaPrice = $priceData['feature_prices']['sauna'];
    $tourPrice = $priceData['feature_prices']['tour'];
    $bedPrice = $priceData['feature_prices']['bed'];

    $statusResponse = array('room' => '', 'is_booking_available' => 'no', 'is_transferCode_valid' => 'no');
    $bookingSuccessful = false;
    $totalCost = 0;
    $room = htmlspecialchars($_POST['room']);
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = $_POST['transferCode'];

    $bookingUID = '';

    $featSauna = false;
    $featTour = false;
    $featBed = false;

    $successfulBooking = false;

    $totalCost = calcRoomPrice($room, $arrivalDate, $departureDate);

    if ($room === "budget") {
        $room = 1;
        $statusResponse['room'] = 'budget';
    } else if ($room === "standard") {
        $room = 2;
        $statusResponse['room'] = 'standard';
    } else if ($room === "luxury") {
        $room = 3;
        $statusResponse['room'] = 'luxury';
    } else {
        $statusResponse['room'] = 'invalid input, must be \'budget\', \'standard\' or \'luxury\'';
    }

    if (isset($_POST['features'])) {
        $features = $_POST['features'];
        foreach ($features as $feature) {
            if ($feature === 'sauna') {
                $totalCost += $saunaPrice;
                $featSauna = true;
            }

            if ($feature === 'tour') {
                $totalCost += $tourPrice;
                $featTour = true;
            }

            if ($feature === 'bed') {
                $totalCost += $bedPrice;
                $featBed = true;
            }
        }
    }

    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $statusResponse['is_booking_available'] = 'yes';
    } else {
        $statusResponse['is_booking_available'] = 'date is taken or incorret, try a different date';
    }

    if (isTransferCodeValid($transferCode, $totalCost)) {
        $statusResponse['is_transferCode_valid'] = 'yes';
    } else {
        $statusResponse['is_transferCode_valid'] = 'transfercode was insufficient or incorrect, try a different code';
    }

    if ($statusResponse['is_booking_available'] === 'yes' && $statusResponse['is_transferCode_valid'] === 'yes') {
        $successfulBooking = true;
    }
    header('Content-type: application/json');
    if ($successfulBooking) {

        $bookingUID = book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $totalCost);
        cashInTransferCode($transferCode);

        $bookedTemplate['arrival_date'] = $arrivalDate;
        $bookedTemplate['departure_date'] = $departureDate;
        $bookedTemplate['total_cost'] = $totalCost;

        if ($featSauna) {
            $featureEntry = array('sauna' => 'yes', 'cost' => $saunaPrice);
            array_push($bookedTemplate['features'], $featureEntry);
        }

        if ($featTour) {
            $featureEntry = array('Island_tour' => 'yes', 'cost' => $tourPrice);
            array_push($bookedTemplate['features'], $featureEntry);
        }

        if ($featBed) {
            $featureEntry = array('extra_bed' => 'yes', 'cost' => $bedPrice);
            array_push($bookedTemplate['features'], $featureEntry);
        }
        $roomBookingUID = array('room' => $room, 'bookingUID' => $bookingUID);
        array_push($bookedTemplate, $roomBookingUID);
        echo json_encode($bookedTemplate);
    } else {
        echo json_encode($statusResponse);
    }
}
