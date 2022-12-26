bookSearchForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const formData = new FormData(bookingForm);

  fetch('API/bookedRooms.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      bookSearchResult.textContent = JSON.stringify(response, null, 3);
    })
    .then(() => {
      bookSearchContainer.classList.add('footer-result-container-open');
    });
});
