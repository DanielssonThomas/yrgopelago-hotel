<?php
$priceData = file_get_contents(__DIR__ . '/../pricing.json');
$priceData = json_decode($priceData, true);

$budgetPrice = $priceData['room_prices']['budget_price'];
$standardPrice = $priceData['room_prices']['standard_price'];
$luxuryPrice = $priceData['room_prices']['luxury_price'];
?>

<main>
    <section class="hotel-container">
        <div class="budget-img">
            <picture>
                <source srcset="Images/budget-large.jpg" media="(min-width: 768px)">
                <source srcset="Images/budget-medium.jpg" media="(min-width: 400px">
                <img src="Images/budget-small.jpg" alt="budget hotel room without walls or roof, but with a great view!">
            </picture>
        </div>
        <section class="budget-info-section">
            <h2>Budget - Room - Price <?= $budgetPrice ?>$/Day</h2>
            <q>The perfect place for good sleep</q>
            <p>Are you looking for a place that gives you the good night sleep you dream of? even though the price is outrageously low? You found the one! This floor comes with no walls, no roof and a nice bed. And as a wonderful bonus you get an extraordinary view in the morning!</p>
            <button class="book-btn">Book now!</button>
        </section>
        <!-- this is standard room -->
        <div class="standard-img">
            <picture>
                <source srcset="Images/standard-large.jpg" media="(min-width: 768px)">
                <source srcset="Images/standard-medium.jpg" media="(min-width: 400px">
                <img src="Images/standard-small.jpg" alt="standard room with a cozy bed">
            </picture>
        </div>
        <section class="standard-info-section">
            <h2>Standard - Room - Price <?= $standardPrice ?>$/Day</h2>
            <q>The average price for a solid room</q>
            <p>Looking for an affordable room that gives you the essentials, walls, roofs, floors, and a nice bed. A truly remarkable step-up from the budget room!</p>
            <button class="book-btn">Book now!</button>
        </section>

        <div class="luxury-img">
            <picture>
                <source srcset="Images/luxury-large.jpg" media="(min-width: 768px)">
                <source srcset="Images/luxury-medium.jpg" media="(min-width: 400px">
                <img src="Images/luxury-small.jpg" alt="luxury hotel room with a nice and tidy area!">
            </picture>
        </div>
        <section class="luxury-info-section">
            <h2>Luxury - Room - Price <?= $luxuryPrice ?>$/Day</h2>
            <q>The most glorious room of all! The one that steals the show! and your wallet...</q>
            <p>Now. This is the one. To empty your wallets and live happily. You get a wonderful home with sofas and multiple floors, access to true luxury and comfortability.</p>
            <button class="book-btn">Book now!</button>
        </section>

    </section>
</main>