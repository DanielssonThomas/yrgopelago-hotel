<?php
$confirmationJSON = file_get_contents(__DIR__ . '/../booking-confirmation.json');
$confirmationJSON = json_decode($confirmationJSON, true);
?>

<header>
    <section class="heading">
        <div class="header-arrow">
            <a href="../index.php">
                <img src="/Images/SVG/back-arrow.svg">
            </a>
        </div>
        <h1><?= $confirmationJSON['hotel'] ?></h1>
        <div class="header-exit">
            <div></div>
            <div></div>
        </div>
    </section>
</header>