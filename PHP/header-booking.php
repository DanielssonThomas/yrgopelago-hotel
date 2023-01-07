<?php

$priceData = file_get_contents(__DIR__ . '/../pricing.json');
$priceData = json_decode($priceData, true);

$confirmationJSON = file_get_contents(__DIR__ . '/../booking-confirmation.json');
$confirmationJSON = json_decode($confirmationJSON, true);

$saunaPrice = $priceData['feature_prices']['sauna'];
$tourPrice = $priceData['feature_prices']['tour'];
$bedPrice = $priceData['feature_prices']['bed'];

$discount = $priceData['discounts']['threeDayDiscount'];
?>

<header>
    <section class="heading">
        <h1><?= $confirmationJSON['hotel'] ?></h1>
        <div class="header-exit">
            <div></div>
            <div></div>
        </div>
    </section>
    <div class="booking">
        <section class="booking-container">
            <div class="booking-err-field"></div>
            <aside class="booking-form">
                <h2>Fill out the following booking form</h2>
                <p>There is a discount of <?= $discount ?>€ for bookings of 3 days or more!</p>
                <form method="POST" class="book-form">
                    <section class="book-form-room">
                        <label for="rooms">Select room:</label>
                        <select name="room" class="room-select">
                            <option value="budget">Budget</option>
                            <option value="standard">Standard</option>
                            <option value="luxury">Luxury</option>
                        </select>
                    </section>
                    <section class="book-form-date">
                        <label for="arrivalDate">Select the day you will be arriving:</label>
                        <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31">
                        <label for="departureDate">Select the day you will departure:</label>
                        <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31">
                    </section>

                    <section class="book-form-transferCode">
                        <label for="transferCode">Enter your transferCode here!</label>
                        <input type="text" name="transferCode">
                    </section>

                    <section class="book-form-feat">
                        <div>
                            <input type="checkbox" name="features[]" value="sauna" id="feat-sauna">
                            <label for="feat-sauna">Add access to our relaxing sauna <?= $saunaPrice ?>€</label>
                        </div>

                        <div>
                            <input type="checkbox" name="features[]" value="tour" id="feat-tour">
                            <label for="feat-tour">Add an adventurous tour across the island <?= $tourPrice ?>€</label>
                        </div>

                        <div>
                            <input type="checkbox" name="features[]" value="bed" id="feat-room">
                            <label for="feat-room">Add an extra bed to your room <?= $bedPrice ?>€</label>
                        </div>
                    </section>
                    <p>Total current cost:</p>
                    <button type="submit">SUBMIT</button>
                </form>
            </aside>
            <div>
                <?php
                require(__DIR__ . '/calendars.php');
                ?>
            </div>

        </section>
    </div>
</header>