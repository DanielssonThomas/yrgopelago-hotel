<?php
$confirmationJSON = file_get_contents(__DIR__ . '/../booking-confirmation.json');
$confirmationJSON = json_decode($confirmationJSON, true);
?>
<div class="star-display">
    <?php for ($i = 0; $i < (int)$confirmationJSON['stars']; $i++) : ?>
        <img src="../Images/SVG/star.svg" alt="small star icon">
    <?php endfor ?>
</div>
<footer>

    <form method="POST" class="footer-form">
        <label for="bookingUID-search">Already booked? Enter your booking-ID below!</label>
        <div>
            <input type="text" name="bookingUID">
            <button type="submit">Enter</button>
        </div>
    </form>
    <section class="footer-result-container">
        <pre class="footer-result"></pre>
    </section>
</footer>