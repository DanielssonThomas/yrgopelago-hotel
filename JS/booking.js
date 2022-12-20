bookingForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const formData = new FormData();

  fetch('PHP/booking.php', {
    method: 'POST',
    body: formData,
  }).then(console.log);
});
