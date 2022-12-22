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
                <h2>Fill out the following booking form</h2>
                <form method="POST" class="book-form">
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
                    <label for="transferCode">Enter your transferCode here!</label>
                    <br>
                    <input type="text" name="transferCode">
                    <br>
                    <input type="checkbox" name="features[]" value="feature-sauna" id="feat-sauna">
                    <label for="feat-sauna">Add access to our relaxing sauna 2€</label>
                    <br>
                    <input type="checkbox" name="features[]" value="feature-tour" id="feat-tour">
                    <label for="feat-tour">Add an adventurous tour across the island 3€</label>
                    <br>
                    <input type="checkbox" name="features[]" value="feature-room" id="feat-room">
                    <label for="feat-room">Add an extra bed to your room 2€</label>
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