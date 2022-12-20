<header>
    <section class="heading">
        <h1>Hotell</h1>
        <div class="header-exit">
            <div></div>
            <div></div>
        </div>
    </section>
    <div class="booking">
        <section class="booking-container">
            <aside class="booking-form">
                <form action="index.php" method="POST">
                    <label for="rooms">Select room:</label>

                    <select name="room">
                        <option value="budget">Budget</option>
                        <option value="standard">Standard</option>
                        <option value="luxury">Luxury</option>
                    </select>
                    <br>
                    <input type="date" name="arrivalDate" min="2023-01-01" max="2023-01-31">
                    <input type="date" name="departureDate" min="2023-01-01" max="2023-01-31">
                    <br>
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