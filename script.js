const bookingBtns = document.querySelectorAll('.book-btn');
const bookingSection = document.querySelector('.booking');
bookingBtns.forEach((e) => {
  e.addEventListener('click', () => {
    bookingSection.classList.toggle('booking-open');
  });
});
