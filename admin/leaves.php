<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "Manage Leave Requests";
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $leaveId = (int) $_POST["leave_id"];
    $action = cleanData($_POST["action"]);
    $note = cleanData($_POST["admin_note"]);

    if ($leaveId > 0 && ($action === "approve" || $action === "reject")) {
        $newStatus = $action === "approve" ? "Approved" : "Rejected";
        $updateSql = "UPDATE leaves_table SET status = '$newStatus', admin_note = '$note' WHERE id = $leaveId";

        if (mysqli_query($conn, $updateSql)) {
            $success = "Leave request updated.";
        } else {
            $error = "Unable to update leave request.";
        }
    }
}

$sql = "SELECT l.*, e.name FROM leaves_table l, employee e WHERE l.employee_id = e.id ORDER BY l.id DESC";
$result = mysqli_query($conn, $sql);

include "../includes/header.php";
?>
<div class="card">
    <h2>Leave Requests</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Admin Note</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["employee_id"]; ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["from_date"]; ?></td>
                <td><?php echo $row["to_date"]; ?></td>
                <td><?php echo $row["reason"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td><?php echo $row["admin_note"]; ?></td>
                <td>
                    <?php if ($row["status"] === "Pending") { ?>
                        <form method="post" action="">
                            <input type="hidden" name="leave_id" value="<?php echo $row["id"]; ?>">
                            <input type="text" name="admin_note" placeholder="Write note">
                            <button type="submit" name="action" value="approve">Approve</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    <?php } else { ?>
                        Processed
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
    </main>
</div>
</body>
</html>