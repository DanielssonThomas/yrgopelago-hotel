<?php
require(__DIR__ . '/../PHP/hotelFunctions.php');
?>

<main>
    <section class="admin-logout">
        <a href="Admin/logout.php">
            <button>Logout</button>
        </a>
    </section>
    <section class="pricing-container">

        <form action="POST" class="pricing-form">
            <div>
                <label for="budget-price">Current budget pricing: <?= $budgetPrice ?>€</label>
                <input type="number" name="budget-price">
            </div>
            <div>
                <label for="standard-price">Current standard pricing: <?= $standardPrice ?>€</label>
                <input type="text" name="standard-price">
            </div>
            <div>
                <label for="luxury-price">Current luxury pricing: <?= $luxuryPrice ?>€</label>
                <input type="text" name="luxury-price">
            </div>

            <button type="submit">Add changes</button>
        </form>

        <form action="POST" class="pricing-form">
            <div>
                <label for="sauna-price">Current sauna pricing: <?= $saunaPrice ?>€</label>
                <input type="number" name="sauna-price">
            </div>
            <div>
                <label for="tour-price">Current tour pricing: <?= $tourPrice ?>€</label>
                <input type="text" name="tour-price">
            </div>
            <div>
                <label for="bed-price">Current extra bed pricing: <?= $bedPrice ?>€</label>
                <input type="text" name="bed-price">
            </div>

            <button type="submit">Add changes</button>
        </form>
    </section>
</main>