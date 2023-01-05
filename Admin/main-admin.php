<?php
require(__DIR__ . '/../PHP/hotelFunctions.php');

$confirmationJSON = file_get_contents(__DIR__ . '/../booking-confirmation.json');
$confirmationJSON = json_decode($confirmationJSON, true);

$starRating = $confirmationJSON['stars'];
$confirmationMessage = $confirmationJSON['addtional_info']['greeting'];

if (isset($_POST['budget-price'], $_POST['standard-price'], $_POST['luxury-price'])) {
    $newBudgetPrice = (int)$_POST['budget-price'];
    $newStandardPrice = (int)$_POST['standard-price'];
    $newLuxuryPrice = (int)$_POST['luxury-price'];

    $jsonData = file_get_contents(__DIR__ . '/../pricing.json');
    $jsonData = json_decode($jsonData, true);

    $newBudgetPrice = null ? $budgetPrice : $newBudgetPrice;
    $newStandardPrice = null ? $standardPrice : $newStandardPrice;
    $newLuxuryPrice = null ? $luxuryPrice : $newLuxuryPrice;

    $jsonData['room_prices']['budget_price'] = $newBudgetPrice;
    $jsonData['room_prices']['standard_price'] = $newStandardPrice;
    $jsonData['room_prices']['luxury_price'] = $newLuxuryPrice;
    file_put_contents(__DIR__ . '/../pricing.json', json_encode($jsonData));
}

if (isset($_POST['sauna-price'], $_POST['tour-price'], $_POST['bed-price'], $_POST['discount-days'])) {
    $newSaunaPrice = (int)$_POST['sauna-price'];
    $newTourPrice = (int)$_POST['tour-price'];
    $newBedPrice = (int)$_POST['bed-price'];
    $newDiscount = (int)$_POST['discount-days'];

    $jsonData = file_get_contents(__DIR__ . '/../pricing.json');
    $jsonData = json_decode($jsonData, true);

    $newSaunaPrice = null ? $saunaPrice : $newSaunaPrice;
    $newTourPrice = null ? $tourPrice : $newTourPrice;
    $newBedPrice = null ? $bedPrice : $newBedPrice;
    $newDiscount = null ? $threeDayDiscount : $newDiscount;

    $jsonData['feature_prices']['sauna'] = $newSaunaPrice;
    $jsonData['feature_prices']['tour'] = $newTourPrice;
    $jsonData['feature_prices']['bed'] = $newBedPrice;
    $jsonData['discounts']['threeDayDiscount'] = $newDiscount;
    file_put_contents(__DIR__ . '/../pricing.json', json_encode($jsonData));
}

if (isset($_POST['hotel-stars'], $_POST['greeting-message'])) {
    global $confirmationJSON;
    $newStarRating = $_POST['hotel-stars'];
    $newMessage = $_POST['greeting-message'];
    if ($newMessage == '') {
        $newMessage = $confirmationJSON['addtional_info']['greeting'];
    }
    $confirmationJSON['stars'] = $newStarRating;
    $confirmationJSON['addtional_info']['greeting'] = $newMessage;
    file_put_contents(__DIR__ . '/../booking-confirmation.json', json_encode($confirmationJSON));
}
?>

<main>
    <section class="admin-logout">
        <a href="Admin/logout.php">
            <button>Logout</button>
        </a>
    </section>
    <section class="pricing-container">

        <form action="" method="POST" class="pricing-form">
            <div>
                <label for="budget-price">Current budget pricing: <?= $budgetPrice ?>€</label>
                <input type="number" name="budget-price" value=<?= $budgetPrice ?> min=0 max=100>
            </div>
            <div>
                <label for="standard-price">Current standard pricing: <?= $standardPrice ?>€</label>
                <input type="number" name="standard-price" value=<?= $standardPrice ?> min=0 max=100>
            </div>
            <div>
                <label for="luxury-price">Current luxury pricing: <?= $luxuryPrice ?>€</label>
                <input type="number" name="luxury-price" value=<?= $luxuryPrice ?> min=0 max=100>
            </div>

            <button type="submit">Add changes</button>
        </form>

        <form action="" method="POST" class="pricing-form">
            <div>
                <label for="sauna-price">Current sauna pricing: <?= $saunaPrice ?>€</label>
                <input type="number" name="sauna-price" value=<?= $saunaPrice ?> min=0 max=100>
            </div>
            <div>
                <label for="tour-price">Current tour pricing: <?= $tourPrice ?>€</label>
                <input type="number" name="tour-price" value=<?= $tourPrice ?> min=0 max=100>
            </div>
            <div>
                <label for="bed-price">Current extra bed pricing: <?= $bedPrice ?>€</label>
                <input type="number" name="bed-price" value=<?= $bedPrice ?> min=0 max=100>
            </div>

            <div>
                <label for="discount-days">Current discount from three days booking: <?= $threeDayDiscount ?></label>
                <input type="number" name="discount-days" value=<?= $threeDayDiscount ?>>
            </div>
            <button type="submit">Add changes</button>
        </form>

        <form action="" method="POST" class="pricing-form">
            <div>
                <label for="hotel-stars">Enter new hotel star value:</label>
                <input type="number" name="hotel-stars" min=0 max=5 value=<?= $starRating ?>>
            </div>
            <div>
                <label for="greeting-message">Current greeting message: <br> <?= $confirmationMessage ?></label>
                <input type="text" name="greeting-message">
            </div>
            <button type="submit">Add changes</button>
        </form>
    </section>

    <section class="bookings-container">
        <table>
            <tr>
                <th>Id</th>
                <th>room id</th>
                <th>arrival date</th>
                <th>departure date</th>
                <th>sauna</th>
                <th>tour</th>
                <th>extra bed</th>
                <th>Total cost</th>
                <th>Booking id</th>
            </tr>

            <?php
            $stmt = $dbh->query('SELECT * FROM bookings');
            $bookingsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <?php foreach ($bookingsData as $currentBooking) : ?>
                <tr>
                    <?php foreach ($currentBooking as $bookingData) : ?>
                        <td><?= $bookingData ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>

        </table>

        <form action="" method="POST" class="delete-booking-form">
            <label for="delete-booking">Delete booking with ID:</label>
            <input type="number" name="delete-booking" min=1>
            <button type="submit">Delete</button>
        </form>
    </section>
</main>