<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Employee");

$pageTitle = "Change Password";
$employeeId = (int) $_SESSION["employee_id"];
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = cleanData($_POST["current_password"]);
    $newPassword = cleanData($_POST["new_password"]);
    $confirmPassword = cleanData($_POST["confirm_password"]);

    if ($currentPassword === "" || $newPassword === "" || $confirmPassword === "") {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        $sql = "SELECT password FROM employee WHERE id = $employeeId";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user && (password_verify($currentPassword, $user["password"]) || $user["password"] === $currentPassword)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE employee SET password = '$hashedNewPassword' WHERE id = $employeeId";

            if (mysqli_query($conn, $updateSql)) {
                $success = "Password changed successfully.";
            } else {
                $error = "Unable to update password.";
            }
        } else {
            $error = "Current password is incorrect.";
        }
    }
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Change Password</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <form action="" method="post">
        <label>Current Password</label>
        <input type="password" name="current_password" required>

        <label>New Password</label>
        <input type="password" name="new_password" minlength="6" pattern="^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}$" required>

        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" value="Change Password">
    </form>
</div>
    </main>
</div>
</body>
</html>