<?php
session_start();
$confirmationJSON = file_get_contents(__DIR__ . '/../booking-confirmation.json');
$confirmationJSON = json_decode($confirmationJSON, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="stylesheet" href="../CSS/typography.css">
    <link rel="stylesheet" href="../CSS/admin-login.css">
    <link rel="stylesheet" href="../CSS/admin-main.css">
    <link rel="stylesheet" href="../CSS/logbook.css">
    <title>logbook page</title>
</head>

<body>
    <section class="admin-logout">
        <a href="../index.php">
            <button class="btn btn-primary">Go Home</button>
        </a>
    </section>
    <header class="admin-header">
        <section class="heading">
            <h1><?= $confirmationJSON['hotel'] ?></h1>
            <div class="header-exit">
                <div></div>
                <div></div>
            </div>
        </section>
    </header>
    <?php
    require(__DIR__ . '/card.php');
    ?>
</body>

</html>
