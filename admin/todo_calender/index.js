const calendar = document.querySelector(".calendar"),
  date = document.querySelector(".date"),
  daysContainer = document.querySelector(".days"),
  prev = document.querySelector(".prev"),
  next = document.querySelector(".next"),
  todayBtn = document.querySelector(".today-btn"),
  gotoBtn = document.querySelector(".goto-btn"),
  dateInput = document.querySelector(".date-input"),
  eventDay = document.querySelector(".event-day"),
  eventDate = document.querySelector(".event-date"),
  eventsContainer = document.querySelector(".events"),
  addEventBtn = document.querySelector(".add-event"),
  addEventWrapper = document.querySelector(".add-event-wrapper"),
  addEventCloseBtn = document.querySelector(".close"),
  addEventTitle = document.querySelector(".event-name"),
  addEventFrom = document.querySelector(".event-time-from"),
  addEventTo = document.querySelector(".event-time-to"),
  addEventSubmit = document.querySelector(".add-event-btn");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();

const months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

// Modified eventsArr to support structured events
let eventsArr = [];

// Function to add event listeners to day elements
function addListener() {
  const days = document.querySelectorAll(".day");
  days.forEach((day) => {
    day.addEventListener("click", (e) => {
      getActiveDay(e.target.innerHTML);
      updateEvents(Number(e.target.innerHTML));
      activeDay = Number(e.target.innerHTML);
      days.forEach((day) => {
        day.classList.remove("active");
      });
      e.target.classList.add("active");

      if (e.target.classList.contains("prev-date")) {
        prevMonth();
        setTimeout(() => activateDay(e.target.innerHTML), 100);
      } else if (e.target.classList.contains("next-date")) {
        nextMonth();
        setTimeout(() => activateDay(e.target.innerHTML), 100);
      }
    });
  });
}

// Initialize the calendar
async function initCalendar() {
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const prevLastDay = new Date(year, month, 0);
  const prevDays = prevLastDay.getDate();
  const lastDate = lastDay.getDate();
  const day = firstDay.getDay();
  const nextDays = 7 - lastDay.getDay() - 1;

  date.innerHTML = months[month] + " " + year;

  let days = "";

  // Previous month days
  for (let x = day; x > 0; x--) {
    days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
  }

  // Current month days
  for (let i = 1; i <= lastDate; i++) {
    let event = eventsArr.find(eventObj => eventObj.day === i && eventObj.month === month + 1 && eventObj.year === year);
    if (i === new Date().getDate() && year === new Date().getFullYear() && month === new Date().getMonth()) {
      activeDay = i;
      getActiveDay(i);
      updateEvents(i);
      days += event
        ? `<div class="day today active event">${i}</div>`
        : `<div class="day today active">${i}</div>`;
    } else {
      days += event ? `<div class="day event">${i}</div>` : `<div class="day">${i}</div>`;
    }
  }

  // Next month days
  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="day next-date">${j}</div>`;
  }

  daysContainer.innerHTML = days;
  addListener(); // Now defined and can be called
  await fetchEvents(); // Fetch events after initializing calendar
}

// Fetch events from the database
async function fetchEvents() {
  const response = await fetch(`fetch.php?month=${month + 1}&year=${year}`);
  if (response.ok) {
    eventsArr = await response.json();
    updateEvents(activeDay);
  } else {
    console.error("Failed to fetch events");
  }
}

// Previous month function
function prevMonth() {
  month--;
  if (month < 0) {
    month = 11;
    year--;
  }
  initCalendar();
}

// Next month function
function nextMonth() {
  month++;
  if (month > 11) {
    month = 0;
    year++;
  }
  initCalendar();
}

prev.addEventListener("click", prevMonth);
next.addEventListener("click", nextMonth);

// Go to today
todayBtn.addEventListener("click", () => {
  today = new Date();
  month = today.getMonth();
  year = today.getFullYear();
  initCalendar();
});

// Handle input for date navigation
dateInput.addEventListener("input", (e) => {
  dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
  if (dateInput.value.length === 2) {
    dateInput.value += "/";
  }
  if (dateInput.value.length > 7) {
    dateInput.value = dateInput.value.slice(0, 7);
  }
  if (e.inputType === "deleteContentBackward") {
    if (dateInput.value.length === 3) {
      dateInput.value = dateInput.value.slice(0, 2);
    }
  }
});

gotoBtn.addEventListener("click", gotoDate);

// Function to go to a specific date
function gotoDate() {
  const dateArr = dateInput.value.split("/");
  if (dateArr.length === 2) {
    if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
      month = dateArr[0] - 1;
      year = dateArr[1];
      initCalendar();
      return;
    }
  }
  alert("Invalid Date");
}

// Get the active day name and date
function getActiveDay(date) {
  const day = new Date(year, month, date);
  const dayName = day.toString().split(" ")[0];
  eventDay.innerHTML = dayName;
  eventDate.innerHTML = date + " " + months[month] + " " + year;
}

// Update events when a day is active
function updateEvents(date) {
  let events = "";
  eventsArr.forEach((event) => {
    if (date === event.day && month + 1 === event.month && year === event.year) {
      events += `<div class="event">
            <div class="title">
              <i class="fas fa-circle"></i>
              <h3 class="event-title">${event.title}</h3>
            </div>
            <div class="event-time">
              <span class="event-time">${event.time_from} - ${event.time_to}</span>
            </div>
        </div>`;
    }
  });
  if (events === "") {
    events = `<div class="no-event">
            <h3>No Events</h3>
        </div>`;
  }
  eventsContainer.innerHTML = events;
}

// Show add event modal
addEventBtn.addEventListener("click", () => {
  addEventWrapper.classList.toggle("active");
});

// Close add event modal
addEventCloseBtn.addEventListener("click", () => {
  addEventWrapper.classList.remove("active");
});

document.addEventListener("click", (e) => {
  if (e.target !== addEventBtn && !addEventWrapper.contains(e.target)) {
    addEventWrapper.classList.remove("active");
  }
});

// Limit event title to 60 characters
addEventTitle.addEventListener("input", (e) => {
  addEventTitle.value = addEventTitle.value.slice(0, 60);
});

// Allow only time in event time from and to
function restrictTimeInput(inputField) {
  inputField.value = inputField.value.replace(/[^0-9:]/g, "");
  if (inputField.value.length === 2) {
    inputField.value += ":";
  }
  if (inputField.value.length > 5) {
    inputField.value = inputField.value.slice(0, 5);
  }
}

addEventFrom.addEventListener("input", () => restrictTimeInput(addEventFrom));
addEventTo.addEventListener("input", () => restrictTimeInput(addEventTo));

// Add event to eventsArr
addEventSubmit.addEventListener("click", async () => {
  const eventTitle = addEventTitle.value;
  const eventTimeFrom = addEventFrom.value;
  const eventTimeTo = addEventTo.value;

  if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
    alert("Please fill all the fields");
    return;
  }

  const newEvent = {
    day: activeDay,
    month: month + 1,
    year: year,
    title: eventTitle,
    time_from: eventTimeFrom,
    time_to: eventTimeTo,
  };

  // Send event to the server
  const response = await fetch("add_event.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(newEvent),
  });

  if (response.ok) {
    addEventWrapper.classList.remove("active");
    addEventTitle.value = "";
    addEventFrom.value = "";
    addEventTo.value = "";
    await fetchEvents();
  } else {
    console.error("Failed to add event");
  }
});

// Initialize calendar on load
initCalendar();
