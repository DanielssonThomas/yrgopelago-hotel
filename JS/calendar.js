let calendarOneActive = false;
let calendarTwoActive = false;
let calendarThreeActive = false;

let calendarIndex = 0;
const toggleBookBtn = () => {
  bookingBtns.forEach((e) => {
    e.classList.toggle('book-btn-close');
  });
};

headerExit.addEventListener('click', () => {
  headerExit.classList.toggle('header-exit-open');
  bookingSection.classList.toggle('booking-container-open');
  toggleBookBtn();
  if (calendarOneActive) {
    calendars[0].classList.toggle('calendar-open');
    calendarOneActive = false;
  }

  if (calendarTwoActive) {
    calendars[1].classList.toggle('calendar-open');
    calendarTwoActive = false;
  }

  if (calendarThreeActive) {
    calendars[2].classList.toggle('calendar-open');
    calendarThreeActive = false;
  }
});

bookingBtns.forEach((e) => {
  if (calendarIndex == 0) {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');
      calendars[0].classList.toggle('calendar-open');
      calendarOneActive = true;
      toggleBookBtn();
    });
  } else if (calendarIndex == 1) {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');
      calendars[1].classList.toggle('calendar-open');
      calendarTwoActive = true;
      toggleBookBtn();
    });
  } else {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');
      calendars[2].classList.toggle('calendar-open');
      calendarThreeActive = true;
      toggleBookBtn();
    });
  }

  calendarIndex++;
});

calendars.forEach((e) => {
  e.classList.add('calendar-closed');
});
