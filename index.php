<?php
include "includes/functions.php";
include "config/db.php";

goToDashboardByRole();

$email = "";
$role = "Employee";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = cleanData($_POST["email"]);
    $password = cleanData($_POST["password"]);
    $role = cleanData($_POST["role"]);

    if ($email === "" || $password === "" || $role === "") {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        if ($role === "Admin") {
            $sql = "SELECT * FROM admin WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $isValid = false;

                if (password_verify($password, $row["password"])) {
                    $isValid = true;
                } elseif ($row["password"] === $password) {
                    $isValid = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_query($conn, "UPDATE admin SET password='$newHash' WHERE id=" . $row["id"]);
                }

                if ($isValid) {
                    $_SESSION["admin_id"] = $row["id"];
                    $_SESSION["username"] = $row["email"];
                    $_SESSION["role"] = "Admin";
                    header("Location: admin/dashboard.php");
                    exit();
                }
            }
        }

        if ($role === "Employee") {
            $sql = "SELECT * FROM employee WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                $isValid = false;

                if (password_verify($password, $row["password"])) {
                    $isValid = true;
                } elseif ($row["password"] === $password) {
                    $isValid = true;
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_query($conn, "UPDATE employee SET password='$newHash' WHERE id=" . $row["id"]);
                }

                if ($isValid) {
                    $_SESSION["employee_id"] = $row["id"];
                    $_SESSION["username"] = $row["name"];
                    $_SESSION["role"] = "Employee";
                    header("Location: employee/dashboard.php");
                    exit();
                }
            }
        }

        $error = "Invalid email, password, or role.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employee Management System</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="wrapper login-box">
    <div class="card">
        <h1>Employee Management System</h1>
        <h2>Login</h2>

        <?php if ($error !== "") { ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php } ?>

        <?php $successMsg = getMessage("success"); ?>
        <?php if ($successMsg !== "") { ?>
            <div class="alert success"><?php echo $successMsg; ?></div>
        <?php } ?>

        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter email" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>

            <label>Role</label>
            <select name="role" required>
                <option value="Admin" <?php if ($role === "Admin") { echo "selected"; } ?>>Admin</option>
                <option value="Employee" <?php if ($role === "Employee") { echo "selected"; } ?>>Employee</option>
            </select>

            <input type="submit" value="Login">
        </form>

    </div>
</div>
</body>
</html>

