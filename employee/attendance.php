<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Employee");

$pageTitle = "My Attendance";
$employeeId = (int) $_SESSION["employee_id"];
$today = date("Y-m-d");
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = cleanData($_POST["status"]);
    $inTime = cleanData($_POST["in_time"]);

    if ($status === "") {
        $error = "Please select attendance status.";
    } else {
        $checkSql = "SELECT id FROM attendance WHERE employee_id = $employeeId AND att_date = '$today'";
        $checkResult = mysqli_query($conn, $checkSql);

        if ($row = mysqli_fetch_assoc($checkResult)) {
            $error = "Attendance already marked for today. You can only mark attendance once per day.";
        } else {
            $insertSql = "INSERT INTO attendance (employee_id, att_date, status, in_time) VALUES ($employeeId, '$today', '$status', '$inTime')";

            if (mysqli_query($conn, $insertSql)) {
                $success = "Attendance marked successfully for today.";
            } else {
                $error = "Unable to mark attendance.";
            }
        }
    }
}

$listSql = "SELECT * FROM attendance WHERE employee_id = $employeeId ORDER BY att_date DESC LIMIT 30";
$listResult = mysqli_query($conn, $listSql);

include "../includes/header.php";
?>
<div class="card">
    <h2>Mark Attendance</h2>
    <p style="color: #666; margin-bottom: 15px;">You can mark your attendance only once per day for today. If you don't mark attendance, you will be marked as <strong>Absent</strong> by the admin.</p>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <form action="" method="post">
        <label>Date (Today)</label>
        <input type="date" value="<?php echo $today; ?>" readonly>

        <label>Status</label>
        <select name="status" required>
            <option value="">-- Select Status --</option>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Leave">Leave</option>
        </select>

        <label>In Time (Optional)</label>
        <input type="time" name="in_time">

        <input type="submit" value="Mark Attendance">
    </form>
</div>

<div class="card">
    <h3>Last 30 Attendance Records</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>In Time</th>
            <th>Out Time</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($listResult)) { ?>
            <tr>
                <td><?php echo $row["att_date"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td><?php echo $row["in_time"]; ?></td>
                <td><?php echo $row["out_time"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
    </main>
</div>
</body>
</html>