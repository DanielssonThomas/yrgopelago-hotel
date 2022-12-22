<?php

declare(strict_types=1);

$responseData = file_get_contents('../response.json');
$responseData = json_decode($responseData, true);
$status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);
header('content-type: application/json');

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'], $_POST['features'])) {
    $room = $_POST['room'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = $_POST['transferCode'];
    $features = $_POST['features'];

    if ($room === "budget") {
        $room = 1;
        $status['totalCost'] + 1;
    } else if ($room === "standard") {
        $room = 2;
        $status['totalCost'] + 2;
    } else if ($room === "luxury") {
        $room = 3;
        $status['totalCost'] + 3;
    }

    foreach ($features as $feature) {
        if ($feature === 'feature-sauna') {
            $status['totalCost'] + 2;
        }

        if ($feature === 'feature-tour') {
            $status['totalCost'] + 3;
        }

        if ($feature === 'feature-room') {
            $status['totalCost'] + 2;
        }
    }

    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $status['is_booking_available'] = true;
    }

    if (isTransferCodeValid($transferCode, $price)) {
        $status['is_transferCode_valid'] = true;
    }

    if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
        book($room, $arrivalDate, $departureDate);
        cashInTransferCode($transferCode);
    }

    echo json_encode($status);
}
