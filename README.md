# Hospital Management System (PHP + SQL)

## Overview

This project is a database-driven hospital management system built using PHP and SQL. It enables efficient management of patient records, appointments, and administrative operations through a dynamic web interface.

---

## Features

* Patient record management (add, update, delete)
* Appointment scheduling system
* User authentication (login system)
* Dynamic database interaction using SQL
* Secure query handling using prepared statements

---

## Security

The application uses **prepared statements** to prevent SQL injection attacks, ensuring secure handling of user input and database queries.

---

## Technologies Used

* PHP
* MySQL
* HTML/CSS
* XAMPP (local server)

---

## Database Design

The system uses a relational database with tables such as:

* Patients
* Appointments
* Users

Refer to `database/schema.sql` for full structure.

---

## Application Screenshots

### Login Page

![Login](assets/screenshots/login.png)

### Dashboard

![Dashboard](assets/screenshots/dashboard.png)

### Patient Management

![Patients](assets/screenshots/patients.png)

---

## Project Structure

```
hospital-management-system/
│
├── src/
├── database/
├── assets/screenshots/
```

---

## How to Run

1. Install XAMPP / any PHP server
2. Place project inside `htdocs/`
3. Import database using `schema.sql`
4. Start Apache and MySQL
5. Open in browser:

```text
http://localhost/hospital-management-system
```

---

## Key Takeaways

* Backend development using PHP
* Database design and SQL queries
* Secure coding practices (SQL injection prevention)
* Building dynamic web applications

---

## Author

Mehul Kapoor
