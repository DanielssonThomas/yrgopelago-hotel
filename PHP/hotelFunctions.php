<?php

declare(strict_types=1);
require_once(__DIR__ . "/../vendor/autoload.php");

$priceData = file_get_contents(__DIR__ . '/../pricing.json');
$priceData = json_decode($priceData, true);

$budgetPrice = $priceData['room_prices']['budget_price'];
$standardPrice = $priceData['room_prices']['standard_price'];
$luxuryPrice = $priceData['room_prices']['luxury_price'];

$saunaPrice = $priceData['feature_prices']['sauna'];
$tourPrice = $priceData['feature_prices']['tour'];
$bedPrice = $priceData['feature_prices']['bed'];

$threeDayDiscount = $priceData['discounts']['threeDayDiscount'];

use GuzzleHttp\Client;

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

function isValidDate(string $arrivalDate, string $departureDate): bool
{
    $arrivalDateArray = explode('-', $arrivalDate);
    $departureDateArray = explode('-', $departureDate);

    $arrivalDay = $arrivalDateArray[2];
    $departureDay = $departureDateArray[2];
    if ($arrivalDay > $departureDay) {
        return false;
    } else {
        return true;
    }
}

function isBookingAvailable(int $room, string $arrivalDate, string $departureDate): bool
{
    global $dbh;
    if (isValidDate($arrivalDate, $departureDate)) {
        $stmt = $dbh->prepare('SELECT * FROM bookings WHERE room_id = :room_id AND' . '(' . 'arrival_date BETWEEN :arrival AND :departure OR departure_date BETWEEN :arrival AND :departure' . ')');
        $stmt->bindParam(':room_id', $room, PDO::PARAM_INT);
        $stmt->bindParam(':arrival', $arrivalDate, PDO::PARAM_STR);
        $stmt->bindParam(':departure', $departureDate, PDO::PARAM_STR);
        $stmt->execute();

        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($response) === 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function calcRoomPrice(string $roomName, string $arrivalDate, string $departureDate): float
{
    if (isValidDate($arrivalDate, $departureDate)) {
        global $budgetPrice, $standardPrice, $luxuryPrice, $threeDayDiscount;
        $numberOfDays = 0;
        $totalPrice = 0;
        $arrivalArray = explode('-', $arrivalDate);
        $departureArray = explode('-', $departureDate);
        $arrivalDay = (int)$arrivalArray[2];
        $departureDay = (int)$departureArray[2];
        $dateDiff = $departureDay - $arrivalDay;

        for ($i = 0; $i < $dateDiff; $i++) {
            $numberOfDays++;
        }

        for ($i = 0; $i <= $numberOfDays; $i++) {
            if ($roomName === 'budget') {
                $totalPrice += $budgetPrice;
            }

            if ($roomName === 'standard') {
                $totalPrice += $standardPrice;
            }

            if ($roomName === 'luxury') {
                $totalPrice += $luxuryPrice;
            }
        }
        if ($dateDiff >= 2) {
            $totalPrice = $totalPrice - $threeDayDiscount;
        }
        return $totalPrice;
    } else {
        return 0;
    }
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
