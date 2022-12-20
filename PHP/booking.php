<?php

declare(strict_types=1);

if (isset($_POST['room'], $_POST['arrivalDate'], $_POST['departureDate'])) {
    $room = $_POST['room'];
    $arrivalDate = $_POST['arrivalDate'];
    $departureDate = $_POST['departureDate'];



    if ($room === "budget") {
        $room = 1;
    } else if ($room === "standard") {
        $room = 2;
    } else {
        $room = 3;
    }

    book($room, $arrivalDate, $departureDate);

    $responseData = file_get_contents('response.json');
    $responseData = json_decode($responseData, true);
    header('content-type: application/json');
    if (book($room, $arrivalDate, $departureDate)) {
        $responseData['is_booking_available'] = true;
        $responseData['successful_booking'] = true;
        echo json_encode($responseData);
    }
}
