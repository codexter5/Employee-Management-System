<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "Manage Attendance";
$error = "";
$success = "";

$today = date("Y-m-d");
$filterDate = isset($_GET["filter_date"]) ? cleanData($_GET["filter_date"]) : $today;

// Edit/Update attendance
$editingRecord = null;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "update") {
    $attendanceId = (int) $_POST["attendance_id"];
    $status = cleanData($_POST["status"]);
    $inTime = cleanData($_POST["in_time"]);
    $outTime = cleanData($_POST["out_time"]);

    if ($attendanceId <= 0 || $status === "") {
        $error = "Invalid attendance record or status.";
    } else {
        $updateSql = "UPDATE attendance SET status = '$status', in_time = '$inTime', out_time = '$outTime' WHERE id = $attendanceId";
        if (mysqli_query($conn, $updateSql)) {
            $success = "Attendance updated successfully.";
            header("Location: attendance.php?filter_date=$filterDate");
            exit();
        } else {
            $error = "Unable to update attendance.";
        }
    }
}

// Get record to edit
if (isset($_GET["edit_id"])) {
    $editId = (int) $_GET["edit_id"];
    $editSql = "SELECT a.*, e.name FROM attendance a, employee e WHERE a.employee_id = e.id AND a.id = $editId";
    $editResult = mysqli_query($conn, $editSql);
    if ($row = mysqli_fetch_assoc($editResult)) {
        $editingRecord = $row;
    }
}

// Add new attendance record
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "add") {
    $employeeId = (int) $_POST["employee_id"];
    $attDate = cleanData($_POST["att_date"]);
    $status = cleanData($_POST["status"]);
    $inTime = cleanData($_POST["in_time"]);
    $outTime = cleanData($_POST["out_time"]);

    if ($employeeId <= 0 || $attDate === "" || $status === "") {
        $error = "Employee, date and status are required.";
    } else {
        $checkSql = "SELECT id FROM attendance WHERE employee_id = $employeeId AND att_date = '$attDate'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "Attendance already exists for this employee on this date.";
        } else {
            $insertSql = "INSERT INTO attendance (employee_id, att_date, status, in_time, out_time) VALUES ($employeeId, '$attDate', '$status', '$inTime', '$outTime')";
            if (mysqli_query($conn, $insertSql)) {
                $success = "Attendance added successfully.";
            } else {
                $error = "Unable to add attendance.";
            }
        }
    }
}

// Mark all unmarked employees as absent for a specific date
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["finalize_date"])) {
    $finalizeDate = cleanData($_POST["finalize_date"]);

    // Get all active employees
    $empSql = "SELECT id FROM employee WHERE status = 'Active'";
    $empResult = mysqli_query($conn, $empSql);

    $markedCount = 0;
    while ($emp = mysqli_fetch_assoc($empResult)) {
        $empId = $emp["id"];
        
        // Check if attendance already marked
        $checkSql = "SELECT id FROM attendance WHERE employee_id = $empId AND att_date = '$finalizeDate'";
        $checkResult = mysqli_query($conn, $checkSql);

        if (mysqli_num_rows($checkResult) === 0) {
            // Mark as absent if not already marked
            $insertSql = "INSERT INTO attendance (employee_id, att_date, status) VALUES ($empId, '$finalizeDate', 'Absent')";
            if (mysqli_query($conn, $insertSql)) {
                $markedCount++;
            }
        }
    }

    $success = "$markedCount employees marked as absent for $finalizeDate.";
}

$empSql = "SELECT id, name FROM employee WHERE status = 'Active' ORDER BY name ASC";
$empResult = mysqli_query($conn, $empSql);

include "../includes/header.php";
?>
<div class="card">
    <h2>Manage Attendance</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
        <!-- Filter Records -->
        <div class="card" style="margin: 0;">
            <h3>Filter & Finalize</h3>
            <form method="get" action="">
                <label>Filter by Date</label>
                <input type="date" name="filter_date" value="<?php echo $filterDate; ?>">
                <input type="submit" value="Filter">
            </form>

            <hr style="margin: 15px 0;">

            <h4>Finalize Attendance</h4>
            <p style="font-size: 12px; color: #666;">Mark all employees who haven't marked attendance as <strong>Absent</strong> for a specific date.</p>
            <form method="post" action="">
                <label>Date to Finalize</label>
                <input type="date" name="finalize_date" value="<?php echo $today; ?>" required>
                <input type="submit" value="Mark Unmarked as Absent">
            </form>
        </div>
    </div>
</div>

<?php if ($editingRecord === null) { ?>
<div class="card">
    <h3>Attendance Records for <?php echo $filterDate; ?></h3>
    <table>
        <tr>
            <th>Employee Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Action</th>
        </tr>
        <?php 
        $listSql = "SELECT a.*, e.name FROM attendance a, employee e WHERE a.employee_id = e.id AND a.att_date = '$filterDate' ORDER BY e.name ASC";
        $listResult = mysqli_query($conn, $listSql);
        
        if (mysqli_num_rows($listResult) > 0) {
            while ($att = mysqli_fetch_assoc($listResult)) { 
        ?>
            <tr>
                <td><?php echo $att["name"]; ?></td>
                <td><?php echo $att["att_date"]; ?></td>
                <td><?php echo $att["status"]; ?></td>
                <td><?php echo $att["in_time"] ?? "-"; ?></td>
                <td><?php echo $att["out_time"] ?? "-"; ?></td>
                <td>
                    <a href="attendance.php?edit_id=<?php echo $att['id']; ?>&filter_date=<?php echo $filterDate; ?>" class="btn-edit">Edit</a>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>No attendance records found.</td></tr>";
        }
        ?>
    </table>
</div>
<?php } else { ?>
<div class="card">
    <h3>Edit Attendance</h3>
    <p><strong>Employee:</strong> <?php echo $editingRecord["name"]; ?></p>
    <p><strong>Date:</strong> <?php echo $editingRecord["att_date"]; ?></p>

    <form method="post" action="">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="attendance_id" value="<?php echo $editingRecord["id"]; ?>">
        
        <label>Status</label>
        <select name="status" required>
            <option value="">-- Select Status --</option>
            <option value="Present" <?php echo $editingRecord["status"] === "Present" ? "selected" : ""; ?>>Present</option>
            <option value="Absent" <?php echo $editingRecord["status"] === "Absent" ? "selected" : ""; ?>>Absent</option>
            <option value="Leave" <?php echo $editingRecord["status"] === "Leave" ? "selected" : ""; ?>>Leave</option>
        </select>

        <label>In Time</label>
        <input type="time" name="in_time" value="<?php echo $editingRecord["in_time"] ?? ""; ?>">

        <label>Out Time</label>
        <input type="time" name="out_time" value="<?php echo $editingRecord["out_time"] ?? ""; ?>">

        <div style="display: flex; gap: 10px; margin-top: 15px;">
            <input type="submit" value="Save Changes">
            <a href="attendance.php?filter_date=<?php echo $filterDate; ?>" class="btn-cancel" style="padding: 8px 15px; background: #999; color: white; text-decoration: none; border-radius: 4px; text-align: center; display: inline-block;">Cancel</a>
        </div>
    </form>
</div>
<?php } ?>
    </main>
</div>
</body>
</html>