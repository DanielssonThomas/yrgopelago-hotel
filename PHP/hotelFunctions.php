<?php

declare(strict_types=1);

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
    $client = new Client();
    $response = $client->request('POST', 'https://yrgopelago.se/centralbank/deposit', [
        'form_params' => [
            'user' => 'thomas',
            'transferCode' => $transferCode
        ]
    ]);
}

function isTransferCodeValid(string $transferCode, int $cost): bool
{
    $client = new Client();

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
        if ($dates['arrival_date'] === $arrivalDate || $dates['departure_date'] === $departureDate) {
            $isBooked = true;
            return false;
        }
    }
    if (!$isBooked) {
        return true;
    }
}

function calcRoomPrice(string $roomName, string $arrivalDate, string $departureDate): int
{
    $numberOfNights = 0;
    $totalPrice = 0;
    $arrival = strtotime($arrivalDate);
    $departure = strtotime($departureDate);
    $dateDiff = $departure - $arrival / (60 * 60 * 24);

    for ($i = 0; $i < $dateDiff; $i++) {
        $numberOfNights++;
    }

    for ($i = 0; $i < $numberOfNights; $i++) {
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
    return $totalPrice;
}

function book(int $room, string $arrivalDate, string $departureDate)
{
    //Creates new connection for database check
    $dbh = connect('../hotel.db');
    //As the booking is available it prepares and binds paramaters before execution of the query
    $book = $dbh->prepare(
        'INSERT INTO bookings(room_id, arrival_date, departure_date)
            VALUES(
            :id,
            :arrivalDate,
            :departureDate
        )'
    );
    $book->bindParam(':id', $room, PDO::PARAM_INT);
    $book->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
    $book->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
    $book->execute();
}
