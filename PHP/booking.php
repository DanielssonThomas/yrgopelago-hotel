<?php

declare(strict_types=1);
require(__DIR__ . '/hotelFunctions.php');

// $status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);

// $room = 'budget';
// $arrivalDate = '2023-01-03';
// $departureDate = '2023-01-4';
// $transferCode = '';

// $featSauna = true;
// $featTour = false;
// $featBed = false;

// $status['totalCost'] = calcRoomPrice($room, $arrivalDate, $departureDate);

// if ($room === "budget") {
//     $room = 1;
// } else if ($room === "standard") {
//     $room = 2;
// } else if ($room === "luxury") {
//     $room = 3;
// }

// $features = array('sauna');
// foreach ($features as $feature) {
//     if ($feature === 'sauna') {
//         $status['totalCost'] += 2;
//         $featSauna = true;
//     }

//     if ($feature === 'tour') {
//         $status['totalCost'] += 3;
//         $featTour = true;
//     }

//     if ($feature === 'bed') {
//         $status['totalCost'] += 2;
//         $featBed = true;
//     }
// }

// if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
//     $status['is_booking_available'] = true;
// }

// if (isTransferCodeValid($transferCode, $status['totalCost'])) {
//     $status['is_transferCode_valid'] = true;
// }

// // if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
// //     book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
// //     cashInTransferCode($transferCode);
// // }

// if ($status['is_booking_available']) {
//     book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
//     $status['is_transferCode_valid'] = true;
// }

// header('Content-type: application/json');
// echo json_encode($status);

// $_POST['transferCode']
if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'], $_POST['transferCode'])) {
    $status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);

    $room = $_POST['room'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    $transferCode = $_POST['transferCode'];

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
                $status['totalCost'] += 2;
                $featSauna = true;
            }

            if ($feature === 'tour') {
                $status['totalCost'] += 3;
                $featTour = true;
            }

            if ($feature === 'bed') {
                $status['totalCost'] += 2;
                $featBed = true;
            }
        }
    }

    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $status['is_booking_available'] = true;
    }

    if (isTransferCodeValid($transferCode, $status['totalCost'])) {
        $status['is_transferCode_valid'] = true;
    }

    // if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
    //     book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
    //     cashInTransferCode($transferCode);
    // }

    if ($status['is_booking_available']) {
        book($room, $arrivalDate, $departureDate, $featSauna, $featTour, $featBed, $status['totalCost']);
        $status['is_transferCode_valid'] = true;
    }

    header('Content-type: application/json');
    echo json_encode($status);
}
