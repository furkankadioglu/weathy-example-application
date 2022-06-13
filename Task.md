## Instructions 📝

### Before you Start

- Initate a fresh`Laravel 8.x` (latest) version.
- Setup Git
- Create a public repo on a Git repo manager of choice (Gitlab, Bitbucker, Github ...) for submitting results
- Setup Postman or a similar API testing tool

---

### The Goal

Create a CRUD API for Weather Forecast Model, run cron jobs and setup queue Jobs and setup basic unit Testing.

The overall goal is to showcase the ability to write well optimized Laravel apps with some complexity.

---

### Task Details

Create a Weather Forecast Model to store the weather forecast from a 3ed party vendor.

Create an API to pull the Weather Forecast for the inputted Date.
If the selected Date is not in the database, pull it in from the Weather API.
If data for the Date is not available in the Weather API return an error.

When pulling, storing and returning the data get/store/return results for all of the following locations:

- New York
- London
- Paris
- Berlin
- Tokyo

4 Times a day,  pull/store/update Weather API results for that day.

Notes:

- Use Jobs at least once
- Use Events at least once
- For Weather API use [https://openweathermap.org/api](https://openweathermap.org/api) or similar