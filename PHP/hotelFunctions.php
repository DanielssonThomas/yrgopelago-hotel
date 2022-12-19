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

function isBookingAvailable(int $room, string $arrivalDate, string $departureDate): bool
{
    $dbh = connect('../hotel.db');
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

function book(int $room, string $arrivalDate, string $departureDate)
{
    if (isBookingAvailable($room, $arrivalDate, $departureDate)) {
        $dbh = connect('../hotel.db');
        $book = $dbh->prepare(
            'INSERT INTO bookings(room_id, arrival_date, departure_date, booked)
            VALUES(
            :id,
            :arrivalDate,
            :departureDate,
            true
        )'
        );
        $book->bindParam(':id', $room, PDO::PARAM_INT);
        $book->bindParam(':arrivalDate', $arrivalDate, PDO::PARAM_STR);
        $book->bindParam(':departureDate', $departureDate, PDO::PARAM_STR);
        $book->execute();
    } else {
        echo "This date is unfortunantly booked for this room, please try a different date";
    }
}
