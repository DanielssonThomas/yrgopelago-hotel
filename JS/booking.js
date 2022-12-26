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

  const data = fetch('PHP/booking.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((response) => {
      if (!response['is_booking_available']) {
        createErrorMessage(
          'That date is unfortunantly booked, please try a different date!'
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
