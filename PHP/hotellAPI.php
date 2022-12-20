<?php

declare(strict_types=1);

$stmt = $dbh->query('SELECT * FROM bookings');
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;
