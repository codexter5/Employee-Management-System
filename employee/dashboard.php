<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Employee");

$pageTitle = "Employee Dashboard";
$employeeId = (int) $_SESSION["employee_id"];

$profileSql = "SELECT * FROM employee WHERE id = $employeeId";
$profileResult = mysqli_query($conn, $profileSql);
$employee = mysqli_fetch_assoc($profileResult);

if (!isset($employee["photo"])) {
    $employee["photo"] = "";
}

$today = date("Y-m-d");
$attendanceCount = 0;
$leavePending = 0;

$attSql = "SELECT COUNT(*) AS total FROM attendance WHERE employee_id = $employeeId AND status = 'Present'";
$attResult = mysqli_query($conn, $attSql);
if ($row = mysqli_fetch_assoc($attResult)) {
    $attendanceCount = $row["total"];
}

$leaveSql = "SELECT COUNT(*) AS total FROM leaves_table WHERE employee_id = $employeeId AND status = 'Pending'";
$leaveResult = mysqli_query($conn, $leaveSql);
if ($row = mysqli_fetch_assoc($leaveResult)) {
    $leavePending = $row["total"];
}

$todayAttSql = "SELECT status FROM attendance WHERE employee_id = $employeeId AND att_date = '$today'";
$todayAttResult = mysqli_query($conn, $todayAttSql);
$todayStatus = "Not marked";
if ($row = mysqli_fetch_assoc($todayAttResult)) {
    $todayStatus = $row["status"];
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Employee Dashboard</h2>
    <p style="margin-top: 6px;">Welcome, <?php echo $employee["name"]; ?>.</p>
</div>

<div class="grid">
    <div class="stat">
        <h3>Total Present Days</h3>
        <p><?php echo $attendanceCount; ?></p>
    </div>
    <div class="stat">
        <h3>Pending Leave Requests</h3>
        <p><?php echo $leavePending; ?></p>
    </div>
    <div class="stat">
        <h3>Today Attendance</h3>
        <p><?php echo $todayStatus; ?></p>
    </div>
</div>

<div class="card">
    <h3>My Details</h3>
    <?php if (isset($employee["photo"]) && $employee["photo"] !== "") { ?>
        <img src="../uploads/<?php echo $employee["photo"]; ?>" alt="photo" class="img-profile">
    <?php } ?>
    <p>Name: <?php echo $employee["name"]; ?></p>
    <p>Email: <?php echo $employee["email"]; ?></p>
    <p>Faculty: <?php echo $employee["faculty"]; ?></p>
    <p>Salary: <?php echo $employee["salary"]; ?></p>
</div>
    </main>
</div>
</body>
</html>