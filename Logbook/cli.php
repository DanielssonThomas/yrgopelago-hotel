<?php

declare(strict_types=1);
include_once __DIR__ . '/../PHP/hotelFunctions.php';

$visits = json_decode(file_get_contents(__DIR__ . '/../logbooks.json'), true); // Get the logbook data

usort($visits, function ($a, $b) {
                    return $a['arrival_date'] > $b['departure_date'] ? 1 : 0; // Sort the logbook data by arrival date
});
$data = array();
foreach ($visits as $visit) { // Loop through the logbook data
                    $data[] = array( // Add the data to the array
                                        $island[] = $visit['island'], // Add the island name to the array
                                        $hotel[] = $visit['hotel'],
                                        $arrival_date[] = $visit['arrival_date'],
                                        $departure_date[] = $visit['departure_date'],
                                        $total_cost[] = $visit['total_cost'],
                                        $stars[] = $visit['stars'],
                                        $features[] = $visit['features'][0],
                                        $additional_info[] = $visit['additional_info'],
                    );
}

$stmt = $dbh->prepare('SELECT * FROM bookings');
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
usort($bookings, function ($a, $b) {
                    return $a['arrival_date'] <=> $b['arrival_date'];
});
$revenue = array_sum(array_column($bookings, 'total_cost'));
$average_income = $revenue / count($bookings);
echo "<br>";
$features_fact = array();
foreach ($bookings as $booking) {
                    $sauna[] = $booking['sauna'];
                    $tour[] = $booking['tour'];
                    $bed[] = $booking['bed'];
}

$features_fact = array(
                    'sauna' => array_sum($sauna),
                    'tour' => array_sum($tour),
                    'bed' => array_sum($bed),
);

arsort($features_fact);
$most_used_feature = key($features_fact);
