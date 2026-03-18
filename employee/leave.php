<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Employee");

$pageTitle = "My Leave Requests";
$employeeId = (int) $_SESSION["employee_id"];
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fromDate = cleanData($_POST["from_date"]);
    $toDate = cleanData($_POST["to_date"]);
    $reason = cleanData($_POST["reason"]);

    if ($fromDate === "" || $toDate === "" || $reason === "") {
        $error = "All fields are required.";
    } elseif ($toDate < $fromDate) {
        $error = "To date cannot be earlier than from date.";
    } else {
        $sql = "INSERT INTO leaves_table (employee_id, from_date, to_date, reason, status) VALUES ($employeeId, '$fromDate', '$toDate', '$reason', 'Pending')";

        if (mysqli_query($conn, $sql)) {
            $success = "Leave request submitted.";
        } else {
            $error = "Unable to submit leave request.";
        }
    }
}

$listSql = "SELECT * FROM leaves_table WHERE employee_id = $employeeId ORDER BY id DESC";
$listResult = mysqli_query($conn, $listSql);

include "../includes/header.php";
?>
<div class="card">
    <h2>Apply Leave</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <form action="" method="post">
        <label>From Date</label>
        <input type="date" name="from_date" required>

        <label>To Date</label>
        <input type="date" name="to_date" required>

        <label>Reason</label>
        <textarea name="reason" rows="3" required></textarea>

        <input type="submit" value="Submit Leave Request">
    </form>
</div>

<div class="card">
    <h3>My Leave History</h3>
    <table>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Admin Note</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($listResult)) { ?>
            <tr>
                <td><?php echo $row["from_date"]; ?></td>
                <td><?php echo $row["to_date"]; ?></td>
                <td><?php echo $row["reason"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td><?php echo $row["admin_note"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
    </main>
</div>
</body>
</html>