bookingForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const formData = new FormData(bookingForm);
  const data = [];

  fetch('PHP/booking.php', {
    method: 'POST',
    body: formData,
  }).then((response) => response.json());

  //   if (!$data['is_booking_available']) {
  //     const div = document.createElement('div');
  //     div.classList.add('form-err');
  //     bookingForm.appendChild(div);
  //   }

  //   if (!$data['is_transferCode_valid']) {
  //     const div = document.createElement('div');
  //     div.classList.add('form-err');
  //     bookingForm.appendChild(div);
  //   }
});
