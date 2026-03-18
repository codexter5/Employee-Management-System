# Employee Management System

This project is a PHP-based Employee Management System organized into modules for administration, employee-side pages, shared configuration, SQL setup, and static assets.

## Project Structure

```text
Employee Management System/
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
│   └── index.php
├── employee/
│   └── index.php
├── includes/
│   └── index.php
├── sql/
│   └── db.sql
├── uploads/
│   ├── cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif
│   ├── default.png
│   ├── index.php
│   └── smiling-business-cartoon-avatar-vector-58404732.avif
└── README.md
```

## Folder and File Description

- **admin/**
  - `dashboard.php`: Admin dashboard page for management-related functions.
  - `employees.php`: Displays list of all employees.
  - `add_employee.php`: Form and logic to add a new employee.
  - `edit_employee.php`: Form and logic to edit employee details.
  - `delete_employee.php`: Handles employee deletion.
  - `attendance.php`: Manages employee attendance records.
  - `leaves.php`: Manages employee leave requests and records.

- **assets/**
  - `style.css`: Main stylesheet used for UI styling across pages.

- **config/**
  - `index.php`: Configuration entry point, commonly used for app or environment settings.

- **employee/**
  - `index.php`: Employee-side main page.

- **includes/**
  - `index.php`: Shared include entry point (typically reusable layout/components or guard file).

- **sql/**
  - `db.sql`: Database schema and/or seed SQL for setting up the system database.

- **uploads/**
  - Avatar images: `cute-cartoon-girl-avatar-black-hair-yellow-shir-vector-58404672.avif`, `smiling-business-cartoon-avatar-vector-58404732.avif`, `default.png`
  - `index.php`: Usually used to prevent direct directory listing.

## Notes

- This README currently focuses on the file structure and role of each part.
- If you want, I can extend it with setup instructions (database import, configuration steps, and how to run locally).
