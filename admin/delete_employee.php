<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    setMessage("error", "Invalid employee id.");
    header("Location: employees.php");
    exit();
}

$id = (int) $_GET["id"];

$getSql = "SELECT id, name, email FROM employee WHERE id = $id";
$getResult = mysqli_query($conn, $getSql);
$emp = mysqli_fetch_assoc($getResult);

if (!$emp) {
    setMessage("error", "Employee not found.");
    header("Location: employees.php");
    exit();
}

// If user confirms deletion
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_delete"])) {
    $deleteAttendanceSql = "DELETE FROM attendance WHERE employee_id = $id";
    mysqli_query($conn, $deleteAttendanceSql);

    $deleteLeaveSql = "DELETE FROM leaves_table WHERE employee_id = $id";
    mysqli_query($conn, $deleteLeaveSql);

    $delSql = "DELETE FROM employee WHERE id = $id";

    if (mysqli_query($conn, $delSql)) {
        setMessage("success", "Employee deleted successfully.");
    } else {
        setMessage("error", "Failed to delete employee.");
    }

    header("Location: employees.php");
    exit();
}

$pageTitle = "Delete Employee";
include "../includes/header.php";
?>

<div class="card" style="max-width: 500px; margin: 50px auto;">
    <h2 style="color: #d9534f;">Confirm Delete</h2>
    <p style="margin: 20px 0;">Are you sure you want to delete this employee?</p>
    
    <div style="background: #f5f5f5; padding: 15px; border-radius: 4px; margin: 20px 0;">
        <p><strong>ID:</strong> <?php echo $emp["id"]; ?></p>
        <p><strong>Name:</strong> <?php echo $emp["name"]; ?></p>
        <p><strong>Email:</strong> <?php echo $emp["email"]; ?></p>
    </div>

    <p style="color: #d9534f; font-weight: bold;">This action cannot be undone. All attendance and leave records will also be deleted.</p>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <form method="post" action="" style="flex: 1;">
            <input type="hidden" name="confirm_delete" value="1">
            <input type="submit" value="Delete Employee" style="width: 100%; background: #d9534f; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer;">
        </form>
        <a href="employees.php" style="flex: 1; padding: 10px; background: #5cb85c; color: white; text-decoration: none; border-radius: 4px; text-align: center;">Cancel</a>
    </div>
</div>

    </main>
</div>
</body>
</html>


