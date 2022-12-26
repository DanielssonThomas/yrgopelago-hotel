bookSearchForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const formData = new FormData(bookSearchForm);

  fetch('API/bookedRooms.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
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

      console.log(JSON.stringify(data, undefined, 2));
      bookSearchResult.textContent = JSON.stringify(data, undefined, 3);
      bookSearchContainer.classList.add('footer-result-container-open');
    });
});
