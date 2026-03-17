# Employee Management System - Reorganized Structure

## New Directory Structure

```
EmployeeManagementSystem/
├── public/
│   ├── login.php          (Login page - entry point)
│   ├── logout.php         (Logout handler)
│   └── index.php          (Redirect to login)
├── admin/
│   ├── dashboard.php
│   ├── index.php
│   ├── sidebar.php
│   ├── view_employees.php
│   ├── insert.php
│   ├── update.php
│   ├── delete.php
│   ├── attendance.php
│   └── leave.php
├── employee/
│   ├── dashboard.php
│   ├── sidebar.php
│   ├── profile.php
│   ├── attendance.php
│   ├── leave.php
│   └── change_password.php
├── includes/              (Shared PHP utilities)
│   ├── db_connection.php
│   ├── helpers.php
│   └── audit.php
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── images/
│   └── uploads/           (User profile photos)
├── database.sql           (Fresh database setup)
└── README.md
```

## What's Changed

### 1. **New `public/` Folder**
   - Entry point for the application
   - Contains login/logout pages
   - All public-facing files

### 2. **New `includes/` Folder**
   - Centralized location for shared PHP functionality
   - Contains:
     - `db_connection.php` - Database connection
     - `helpers.php` - Utility functions (sanitize, validation, authentication)
     - `audit.php` - Audit logging functions

### 3. **Reorganized `assets/` Folder**
   - Better file organization:
     - `css/` - Stylesheets
     - `images/` - Static images
     - `uploads/` - User profile photos and uploads

### 4. **Updated Database**
   - Improved schema with:
     - Added `updated_at` timestamps
     - Added database indexes for better performance
     - Better table drop order to avoid foreign key conflicts
     - Sample data included (2 employees for testing)
   
   **Default Credentials:**
   - **Admin**: `admin@ems.com` / `admin123`
   - **Employee 1**: `john@ems.com` / `emppass123`
   - **Employee 2**: `jane@ems.com` / `emppass123`

## Next Steps

### 1. **Update Include Paths**
   All existing PHP files need their include paths updated:
   
   **Old:**
   ```php
   include "db_connection.php";
   include "helpers.php";
   include "audit.php";
   ```
   
   **New:**
   ```php
   include "../includes/db_connection.php";
   include "../includes/helpers.php";
   include "../includes/audit.php";
   ```

### 2. **Update CSS and Asset Paths**
   Update all CSS, image, and upload paths:
   
   **Old:**
   ```html
   <link rel="stylesheet" href="css/style.css">
   <img src="uploads/photo.jpg">
   ```
   
   **New:**
   ```html
   <link rel="stylesheet" href="../assets/css/style.css">
   <img src="../assets/uploads/photo.jpg">
   ```

### 3. **Setup Database**
   - Open phpMyAdmin
   - Create a new database or use existing `employee_db`
   - Import/run `database.sql`
   - Done!

### 4. **Move Remaining Files**
   - Move `admin/*.php` files to the `admin/` folder
   - Move `employee/*.php` files to the `employee/` folder
   - Move `css/style.css` to `assets/css/`
   - Move existing uploads to `assets/uploads/`

### 5. **Update Web Server Configuration (if needed)**
   - Update `DocumentRoot` to point to the application root
   - Or access via: `http://localhost/EmployeeManagementSystem/public/login.php`

## Benefits of This Structure

✅ **Clear Separation of Concerns**
- Public files separate from admin/employee sections
- Shared utilities centralized

✅ **Better Security**
- Sensitive files (`includes/`) not directly accessible
- Clearer access control

✅ **Improved Maintainability**
- Easier to find and update files
- Better organization as app grows

✅ **Scalability**
- Ready for MVC pattern adoption if needed
- Easy to add new modules

## File Paths Reference

| Old Path | New Path |
|----------|----------|
| `login.php` | `public/login.php` |
| `logout.php` | `public/logout.php` |
| `db_connection.php` | `includes/db_connection.php` |
| `helpers.php` | `includes/helpers.php` |
| `audit.php` | `includes/audit.php` |
| `css/style.css` | `assets/css/style.css` |
| `uploads/*` | `assets/uploads/*` |
