# Employee Management System

This project is a PHP-based Employee Management System organized into modules for administration, employee-side pages, shared configuration, SQL setup, and static assets.

## Project Structure

```text
Employee Management System/
├── index.php
├── logout.php
├── README.md
├── admin/
│   ├── add_employee.php
│   ├── attendance.php
│   ├── dashboard.php
│   ├── delete_employee.php
│   ├── edit_employee.php
│   ├── employees.php
│   └── leaves.php
├── assets/
│   └── style.css
├── config/
│   └── db.php
├── employee/
│   ├── attendance.php
│   ├── change_password.php
│   ├── dashboard.php
│   ├── leave.php
│   └── profile.php
├── includes/
│   ├── functions.php
│   └── header.php
├── sql/
│   └── emsystem.sql
├── uploads/
│   └── default.png
```

## Folder and File Description

- **Root Files**
  - `index.php`: Entry point and login page for the system.
  - `logout.php`: Logs out the current user and clears session state.
  - `README.md`: Project documentation.

- **admin/**
  - `dashboard.php`: Admin dashboard page.
  - `employees.php`: Displays all employee records.
  - `add_employee.php`: Adds a new employee.
  - `edit_employee.php`: Updates employee details.
  - `delete_employee.php`: Deletes an employee record.
  - `attendance.php`: Manages attendance data from the admin side.
  - `leaves.php`: Manages leave requests from the admin side.

- **assets/**
  - `style.css`: Main stylesheet for the system UI.

- **config/**
  - `db.php`: Database connection and configuration settings.

- **employee/**
  - `dashboard.php`: Employee dashboard page.
  - `attendance.php`: Employee attendance view.
  - `leave.php`: Employee leave request page.
  - `profile.php`: Employee profile page.
  - `change_password.php`: Employee password update page.

- **includes/**
  - `header.php`: Shared header/layout include.
  - `functions.php`: Reusable helper and utility functions.

- **sql/**
  - `emsystem.sql`: Database schema/data script for system setup.

- **uploads/**
  - `default.png`: Default profile image used by the application.
