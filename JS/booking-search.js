bookSearchForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const formData = new FormData(bookSearchForm);

  fetch('API/bookedRooms.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      try {
        if (data[0]['room_id'] === 1) {
          data[0]['room_id'] = 'budget';
        } else if (data[0]['room_id'] === 2) {
          data[0]['room_id'] = 'standard';
        } else {
          data[0]['room_id'] = 'luxury';
        }

        if (data[0]['sauna']) {
          data[0]['sauna'] = 'yes';
        } else {
          data[0]['sauna'] = 'no';
        }

        if (data[0]['tour']) {
          data[0]['tour'] = 'yes';
        } else {
          data[0]['tour'] = 'no';
        }

        if (data[0]['bed']) {
          data[0]['bed'] = 'yes';
        } else {
          data[0]['bed'] = 'no';
        }

        bookSearchResult.textContent = JSON.stringify(data, undefined, 3);
        bookSearchContainer.classList.add('footer-result-container-open');
      } catch {
        bookSearchResult.textContent =
          'There was no booking for that ID, are you sure it is correct?';
        bookSearchContainer.classList.add('footer-result-container-open');
        console.log('error');
      }
    });
});
