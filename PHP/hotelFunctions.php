<?php

declare(strict_types=1);
require_once(__DIR__ . "/../vendor/autoload.php");

use GuzzleHttp\Client;
use Dotenv\Dotenv;

$client = new Client();
/* 
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");
                  
one function to create a guid,
and one function to control if a guid is valid.
*/

$dbh = connect('../hotel.db');

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    return $db;
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}

function cashInTransferCode(string $transferCode)
{
    global $client;
    $response = $client->request('POST', 'https://yrgopelago.se/centralbank/deposit', [
        'form_params' => [
            'user' => 'thomas',
            'transferCode' => $transferCode
        ]
    ]);
}

function isTransferCodeValid(string $transferCode, float $cost): bool
{
    global $client;
    if (isValidUuid($transferCode)) {
        $response = $client->request('POST', 'https://yrgopelago.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $cost
            ]
        ]);

        if ($response->hasHeader('Content-Length')) {
            $data = json_decode($response->getBody()->getContents(), true);
            if (array_key_exists('error', $data)) {
                return false;
            } else {
                return true;
            }
        }
    } else {
        return false;
    }
}

function seperateToDayValue(string $arrivalDate, string $departureDate): array
{
    $daysInbetween = [];

    $arrivalDateArray = explode('-', $arrivalDate);
    $departureDateArray = explode('-', $departureDate);

    $arrivalDay = $arrivalDateArray[2] - 1;
    $departureDay = $departureDateArray[2];
    $saveDate = $arrivalDay;

    while ($saveDate != $departureDay) {
        array_push($daysInbetween, $saveDate);
        $saveDate++;
    }
    return $daysInbetween;
}

function isBookingAvailable(int $room, string $arrivalDate, string $departureDate): bool
{
    global $dbh;
    $stmt = $dbh->prepare('SELECT arrival_date, departure_date FROM bookings WHERE room_id = :id');
    $stmt->bindParam(':id', $room, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $isBooked = false;
    foreach ($data as $dates) {

        foreach (seperateToDayValue($dates['arrival_date'], $dates['departure_date']) as $bookedDay) {
            foreach (seperateToDayValue($arrivalDate, $departureDate) as $bookingDay) {
                if ($bookedDay == $bookingDay) {
                    $isBooked = true;
                    return false;
                }
            }
        }
    }
    if (!$isBooked) {
        return true;
    }
}

function calcRoomPrice(string $roomName, string $arrivalDate, string $departureDate): float
{
    $numberOfNights = 0;
    $totalPrice = 0;
    $arrivalArray = explode('-', $arrivalDate);
    $departureArray = explode('-', $departureDate);
    $arrivalDay = (int)$arrivalArray[2];
    $departureDay = (int)$departureArray[2];
    $dateDiff = $departureDay - $arrivalDay;

    for ($i = 0; $i < $dateDiff; $i++) {
        $numberOfNights++;
    }

    $numberOfNights = round($numberOfNights / 2);

    for ($i = 0; $i <= $numberOfNights; $i++) {
        if ($roomName === 'budget') {
            $totalPrice++;
        }

        if ($roomName === 'standard') {
            $totalPrice += 2;
        }

        if ($roomName === 'luxury') {
            $totalPrice += 3;
        }
    }
    if ($dateDiff > 3) {
        $totalPrice *= 0.7;
    }
    return $totalPrice;
}

function book(int $room, string $arrivalDate, string $departureDate, bool $featSauna, bool $featTour, bool $featBed, float $totalCost): string
{
    //Creates new connection for database check
    $dbh = connect('../hotel.db');
    $uuid = guidv4();
    //As the booking is available it prepares and binds paramaters before execution of the query
    $book = $dbh->prepare(
        'INSERT INTO bookings(room_id, arrival_date, departure_date, sauna, tour, bed, total_cost, bookingUID)
            VALUES(
            :id,
            :arrivalDate,
            :departureDate,
            :sauna,
            :tour,
            :bed,
            :total_cost,
            :bookingUID
        )'
    );
    $book->bindParam(':id', $room, PDO::PARAM_INT);
    $book->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
    $book->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
    $book->bindParam(':sauna', $featSauna, PDO::PARAM_BOOL);
    $book->bindParam(':tour', $featTour, PDO::PARAM_BOOL);
    $book->bindParam(':bed', $featBed, PDO::PARAM_BOOL);
    $book->bindParam(':total_cost', $totalCost);
    $book->bindParam(':bookingUID', $uuid, PDO::PARAM_STR);
    $book->execute();
    return $uuid;
}
