<?php
require(__DIR__ . '/../PHP/hotelFunctions.php');
?>

<main>
    <section class="admin-logout">
        <a href="Admin/logout.php">
            <button>Logout</button>
        </a>
    </section>
    <form action="POST">
        <label for="budget-price">Current budget pricing: <?= $budgetPrice ?></label>
        <input type="text" name=" budget-price">


    </form>
</main>