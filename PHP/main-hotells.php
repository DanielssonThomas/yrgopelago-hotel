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
            <h2>Budget - Room - Price <?= $budgetPrice ?>€/Night</h2>
            <q>Perfect to get a room that gets the job done</q>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptatem deserunt quibusdam sint ducimus, quas ab ea veritatis nulla harum neque voluptates et, mollitia maxime nobis repellat nesciunt magni voluptas inventore!</p>
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
            <h2>Standard - Room - Price <?= $standardPrice ?>€/Night</h2>
            <q>The average price for a solid room</q>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, est. Deserunt quo dignissimos minus nihil deleniti odio, reiciendis aspernatur dolor aliquam velit vitae fuga? Reprehenderit id a laborum nobis sed?</p>
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
            <h2>Luxury - Room - Price <?= $luxuryPrice ?>€/Night</h2>
            <q>The most glorious room of all! The one that steals the show! and your wallet...</q>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A repellendus cupiditate ipsa, libero repellat corporis consectetur, error facilis, quis nostrum totam. Error laborum nisi est eius tempora minus harum mollitia?</p>
            <button class="book-btn">Book now!</button>
        </section>

    </section>
</main>