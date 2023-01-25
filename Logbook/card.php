<?php

use GuzzleHttp\Promise\Is;

include_once __DIR__ . '/cli.php';
?>

<section> <!-- This is a card because the feature section could have multiple items and to display all of it in a nice way the card design from admin was chosen -->
  <div class="row">
    <?php foreach ($data as $i => $value) : ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Island: <?= $island[$i] ?></h5>
          <h6 class="card-subtitle">Hotel: <?= $hotel[$i] ?></h6>
          <p class="card-text">Arrival date: <?= $arrival_date[$i] ?></p>
          <p class="card-text">Departure date: <?= $departure_date[$i] ?></p>
          <p class="card-text">Total cost: <?= $total_cost[$i] ?></p>
          <p class="card-text">Stars: <?= $stars[$i] ?></p>
          <p class="card-text">Features: <?= $features[$i]['name'] ?></p>
          <p class="card-text">Cost: <?= $features[$i]['cost'] ?></p>
          <?php if (is_array($additional_info[$i])) : ?>
            <p class="card-text">Additional info:</p>
            <?php foreach ($additional_info[$i] as $info) : ?>
              <?php foreach ($info as $key => $value) : ?>
                <p class="card-text"><?= $key ?>: <?= $value ?></p>
              <?php endforeach; ?>
            <?php endforeach; ?>
          <?php else : ?>
            <p class="card-text">Additional info: </p>
            <p><?= $additional_info[$i] ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<section class="bookings-container"> <!-- This is a table because the admin page had a table and a card, and for this section the table works better then the other section -->
  <table>
    <tr>
      <th>Revenue</th>
      <th>Average income</th>
      <th>Most popular feature</th>
    </tr>
    <tr>
      <td><?= $revenue ?></td>
      <td><?= $average_income ?></td>
      <td><?= $most_used_feature ?></td>
    </tr>
  </table>

</section>
