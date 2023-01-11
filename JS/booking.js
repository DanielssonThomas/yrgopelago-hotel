displayNumber = 0;

calendarSelection.addEventListener('change', () => {
  if (calendarSelection.value === 'budget') {
    toggleCalendar(1);
  } else if (calendarSelection.value === 'standard') {
    toggleCalendar(2);
  } else if (calendarSelection.value === 'luxury') {
    toggleCalendar(3);
  }
});

const fetchPrices = async () => {
  const res = await fetch('../pricing.json');
  const data = await res.json();
  return data;
};

saunaSelectInput.addEventListener('change', async () => {
  data = await fetchPrices();
  if (saunaSelectInput.checked) {
    displayNumber += data['feature_prices']['sauna'];
  } else {
    displayNumber -= data['feature_prices']['sauna'];
  }

  bookingCostDisplay.textContent = `Total current cost: ${displayNumber}`;
});

tourSelectInput.addEventListener('change', async () => {
  data = await fetchPrices();
  if (tourSelectInput.checked) {
    displayNumber += data['feature_prices']['tour'];
  } else {
    displayNumber -= data['feature_prices']['tour'];
  }
  bookingCostDisplay.textContent = `Total current cost: ${displayNumber}`;
});

bedSelectInput.addEventListener('change', async () => {
  data = await fetchPrices();
  if (bedSelectInput.checked) {
    displayNumber += data['feature_prices']['bed'];
  } else {
    displayNumber -= data['feature_prices']['bed'];
  }
  bookingCostDisplay.textContent = `Total current cost: ${displayNumber}`;
});

(arrivalInput, departureInput).addEventListener('change', async () => {
  saunaSelectInput.checked = false;
  tourSelectInput.checked = false;
  bedSelectInput.checked = false;
  displayNumber -= displayNumber;
  arrivalArray = arrivalInput.value.toString();
  arrivalArray = arrivalArray.split('-');
  arrivalDate = parseInt(arrivalArray[2]);

  departureArray = departureInput.value.toString();
  departureArray = departureArray.split('-');
  departureDate = parseInt(departureArray[2]);

  totalDays = departureDate - arrivalDate;

  priceData = await fetchPrices();

  for (let i = 0; i <= totalDays; i++) {
    displayNumber +=
      priceData['room_prices'][`${calendarSelection.value}_price`];
  }

  if (totalDays >= 2) {
    displayNumber -= priceData['discounts']['threeDayDiscount'];
  }

  bookingCostDisplay.textContent = `Total current cost: ${displayNumber}`;
});

bookingForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const formData = new FormData(bookingForm);

  const createErrorMessage = (message) => {
    const div = document.createElement('div');
    const h3 = document.createElement('h3');
    div.classList.add('form-err');
    h3.textContent = message;
    div.appendChild(h3);
    bookingErrField.appendChild(div);
    setTimeout(() => {
      div.remove();
    }, 10000);
  };

  fetch('PHP/booking.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (!response['is_booking_available']) {
        createErrorMessage(
          'That date is unfortunantly booked or your input was invalid, please try a different date!'
        );
      } else if (!response['is_transferCode_valid']) {
        createErrorMessage(
          'Your transfer code was invalid or insufficient, please try again'
        );
      }

      if (
        response['is_booking_available'] &&
        response['is_transferCode_valid']
      ) {
        window.location.href = 'PHP/booked.php';
      }
    });
});
