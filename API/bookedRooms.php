<?php
require(__DIR__ . '/../PHP/hotelFunctions.php');

if (isset($_POST['bookingUID'])) {
    $response = $_POST['bookingUID'];

    $stmt = $dbh->prepare('SELECT room_id, arrival_date, departure_date, sauna, tour, bed, total_cost, bookingUID FROM bookings WHERE bookingUID = :bookingUID');
    $stmt->bindParam(':bookingUID', $response, PDO::PARAM_STR);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data = json_encode($data);

    header('Content-type: application/json');
    echo $data;
}
