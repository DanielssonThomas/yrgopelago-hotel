<?php

declare(strict_types=1);
require(__DIR__ . '/hotelFunctions.php');
// $_POST['transferCode']

// $responseData = file_get_contents('../response.json');
// $responseData = json_decode($responseData, true);
// $status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);

// $room = 'budget';
// $arrivalDate = '2023-01-02';
// $departureDate = '2023-01-04';
// // $transferCode = $_POST['transferCode'];
// $features = array('feature-sauna', 'feature-room');

// if ($room === "budget") {
//     $room = 1;
//     $status['totalCost'] += 1;
// } else if ($room === "standard") {
//     $room = 2;
//     $status['totalCost'] += 2;
// } else if ($room === "luxury") {
//     $room = 3;
//     $status['totalCost'] += 3;
// }

// foreach ($features as $feature) {
//     if ($feature === 'feature-sauna') {
//         $status['totalCost'] += 2;
//     }

//     if ($feature === 'feature-tour') {
//         $status['totalCost'] += 3;
//     }

//     if ($feature === 'feature-room') {
//         $status['totalCost'] += 2;
//     }
// }

// if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
//     $status['is_booking_available'] = true;
// }

// // if (isTransferCodeValid($transferCode, $price)) {
// //     $status['is_transferCode_valid'] = true;
// // }

// // if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
// //     book($room, $arrivalDate, $departureDate);
// //     cashInTransferCode($transferCode);
// // }

// if ($status['is_booking_available']) {
//     book($room, $arrivalDate, $departureDate);
//     $status['is_transferCode_valid'] = true;
// }

// // array_push($responseData, $status);
// // $responseData = json_encode($responseData);
// // file_put_contents('../response.json', $responseData);
// header('Content-Type: application/json');
// echo json_encode($status);

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'])) {

    $responseData = file_get_contents('../response.json');
    $responseData = json_decode($responseData, true);
    $status = array('is_booking_available' => false, 'is_transferCode_valid' => false, 'totalCost' => 0);

    $room = $_POST['room'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];
    // $transferCode = $_POST['transferCode'];

    if ($room === "budget") {
        $room = 1;
        $status['totalCost'] += 1;
    } else if ($room === "standard") {
        $room = 2;
        $status['totalCost'] += 2;
    } else if ($room === "luxury") {
        $room = 3;
        $status['totalCost'] += 3;
    }

    if (isset($_POST['features'])) {
        $features = $_POST['features'];
        foreach ($features as $feature) {
            if ($feature === 'feature-sauna') {
                $status['totalCost'] += 2;
            }

            if ($feature === 'feature-tour') {
                $status['totalCost'] += 3;
            }

            if ($feature === 'feature-room') {
                $status['totalCost'] += 2;
            }
        }
    }

    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $status['is_booking_available'] = true;
    }

    // if (isTransferCodeValid($transferCode, $price)) {
    //     $status['is_transferCode_valid'] = true;
    // }

    // if ($status['is_booking_available'] && $status['is_transferCode_valid']) {
    //     book($room, $arrivalDate, $departureDate);
    //     cashInTransferCode($transferCode);
    // }

    if ($status['is_booking_available']) {
        book($room, $arrivalDate, $departureDate);
        $status['is_transferCode_valid'] = true;
    }

    // array_push($responseData, $status);
    // file_put_contents('../response.json', $responseData);
    // $responseData = json_encode($responseData);
    header('Content-type: application/json');
    echo json_encode($status);
}
