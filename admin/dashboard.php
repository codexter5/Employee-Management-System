<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "Admin Dashboard";

$totalEmployees = 0;
$todayPresent = 0;
$pendingLeaves = 0;

$sql1 = "SELECT COUNT(*) AS total FROM employee";
$res1 = mysqli_query($conn, $sql1);
if ($row = mysqli_fetch_assoc($res1)) {
    $totalEmployees = $row["total"];
}

$today = date("Y-m-d");
$sql2 = "SELECT COUNT(*) AS total FROM attendance WHERE att_date = '$today' AND status = 'Present'";
$res2 = mysqli_query($conn, $sql2);
if ($row = mysqli_fetch_assoc($res2)) {
    $todayPresent = $row["total"];
}

$sql3 = "SELECT COUNT(*) AS total FROM leaves_table WHERE status = 'Pending'";
$res3 = mysqli_query($conn, $sql3);
if ($row = mysqli_fetch_assoc($res3)) {
    $pendingLeaves = $row["total"];
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Admin Dashboard</h2>
    <p style="margin-top: 6px;">Welcome, <?php echo $_SESSION["username"]; ?>.</p>
</div>

<div class="grid">
    <div class="stat">
        <h3>Total Employees</h3>
        <p><?php echo $totalEmployees; ?></p>
    </div>
    <div class="stat">
        <h3>Today Present</h3>
        <p><?php echo $todayPresent; ?></p>
    </div>
    <div class="stat">
        <h3>Pending Leaves</h3>
        <p><?php echo $pendingLeaves; ?></p>
    </div>
</div>
    </main>
</div>
</body>
</html>