let calendarActive = [false, false, false];

let calendarIndex = 0;

const toggleCalendar = (calendarIndex) => {
  let index = 0;

  //   const calendars = ['Budget', 'Standard', 'Luxury'];

  //   calendarSelection.value = calendars[calendarIndex];

  calendarActive.forEach((e) => {
    if (e) {
      calendars[index].classList.toggle('calendar-open');
      calendarActive[index] = false;
    }
    index++;
  });

  if (calendarIndex === 1) {
    calendars[0].classList.toggle('calendar-open');
    calendarSelection.value = 'budget';
    calendarActive[0] = true;
  } else if (calendarIndex === 2) {
    calendars[1].classList.toggle('calendar-open');
    calendarSelection.value = 'standard';
    calendarActive[1] = true;
  } else {
    calendars[2].classList.toggle('calendar-open');
    calendarSelection.value = 'luxury';
    calendarActive[2] = true;
  }
};

calendarSelection.addEventListener('change', () => {
  if (calendarSelection.value === 'budget') {
    toggleCalendar(1);
  } else if (calendarSelection.value === 'standard') {
    toggleCalendar(2);
  } else if (calendarSelection.value === 'luxury') {
    toggleCalendar(3);
  }
});

headerExit.addEventListener('click', () => {
  headerExit.classList.toggle('header-exit-open');
  bookingSection.classList.toggle('booking-container-open');
  if (calendarActive[0]) {
    calendars[0].classList.toggle('calendar-open');
    calendarActive[0] = false;
  }

  if (calendarActive[1]) {
    calendars[1].classList.toggle('calendar-open');
    calendarActive[1] = false;
  }

  if (calendarActive[2]) {
    calendars[2].classList.toggle('calendar-open');
    calendarActive[2] = false;
  }
});

bookingBtns.forEach((e) => {
  if (calendarIndex == 0) {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');

      toggleCalendar(1);
    });
  } else if (calendarIndex == 1) {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');
      toggleCalendar(2);
    });
  } else {
    e.addEventListener('click', () => {
      bookingSection.classList.toggle('booking-container-open');
      headerExit.classList.toggle('header-exit-open');
      toggleCalendar(3);
    });
  }

  calendarIndex++;
});

calendars.forEach((e) => {
  e.classList.add('calendar-closed');
});
