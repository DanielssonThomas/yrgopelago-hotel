const bookingBtns = document.querySelectorAll('.book-btn');
const bookingSection = document.querySelector('.booking-container');
const headerExit = document.querySelector('.header-exit');

const toggleBookBtn = () => {
  bookingBtns.forEach((e) => {
    e.classList.toggle('book-btn-close');
  });
};

headerExit.addEventListener('click', () => {
  headerExit.classList.toggle('header-exit-open');
  bookingSection.classList.toggle('booking-container-open');
  toggleBookBtn();
});

bookingBtns.forEach((e) => {
  e.addEventListener('click', () => {
    bookingSection.classList.toggle('booking-container-open');
    headerExit.classList.toggle('header-exit-open');
    toggleBookBtn();
  });
});
