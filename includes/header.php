<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Employee Management System"; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="wrapper">
    <header class="topbar">
        <h1>Employee Management System</h1>
        <?php if (isset($_SESSION["role"])) { ?>
            <nav>
                <?php if ($_SESSION["role"] === "Admin") { ?>
                    <a href="dashboard.php" class="nav-blue">Dashboard</a>
                    <a href="add_employee.php" class="nav-green">Add Employee</a>
                    <a href="employees.php" class="nav-cyan">View Employee</a>
                    <a href="attendance.php" class="nav-orange">Attendance</a>
                    <a href="leaves.php" class="nav-purple">Leaves</a>
                <?php } else { ?>
                    <a href="dashboard.php" class="nav-blue">Dashboard</a>
                    <a href="profile.php" class="nav-green">Update Profile</a>
                    <a href="attendance.php" class="nav-orange">Attendance</a>
                    <a href="leave.php" class="nav-purple">Leaves</a>
                    <a href="change_password.php" class="nav-cyan">Change Password</a>
                <?php } ?>
                <a href="../logout.php" class="nav-red">Logout</a>
            </nav>
        <?php } ?>
    </header>
    <main>

