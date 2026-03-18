<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "Edit Employee";
$error = "";
$success = "";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: employees.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM employee WHERE id = $id";
$result = mysqli_query($conn, $sql);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    setMessage("error", "Employee not found.");
    header("Location: employees.php");
    exit();
}

if (!isset($employee["photo"])) {
    $employee["photo"] = "";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = cleanData($_POST["name"]);
    $email = cleanData($_POST["email"]);
    $password = cleanData($_POST["password"]);
    $dob = cleanData($_POST["dob"]);
    $gender = isset($_POST["gender"]) ? cleanData($_POST["gender"]) : "";
    $faculty = cleanData($_POST["faculty"]);
    $salary = cleanData($_POST["salary"]);
    $phone = cleanData($_POST["phone"]);
    $address = cleanData($_POST["address"]);
    $status = cleanData($_POST["status"]);
    $photo = cleanData($_POST["current_photo"]);
    $photoColumnExists = false;

    $colCheck = mysqli_query($conn, "SHOW COLUMNS FROM employee LIKE 'photo'");
    if ($colCheck && mysqli_num_rows($colCheck) > 0) {
        $photoColumnExists = true;
    }

    if ($name === "" || $email === "" || $dob === "" || $gender === "" || $faculty === "" || $salary === "" || $phone === "") {
        $error = "Please fill required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!is_numeric($salary)) {
        $error = "Salary must be a number.";
    } elseif (!is_numeric($phone)) {
        $error = "Phone must be numbers only.";
    } else {
        if ($photoColumnExists && isset($_FILES["photo"]) && $_FILES["photo"]["name"] !== "") {
            $photo = cleanData($_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], "../uploads/" . $photo);
        }

        $passwordSqlPart = "";
        if ($password !== "") {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $passwordSqlPart = ", password = '$hashedPassword'";
        }

        if ($photoColumnExists) {
            $updateSql = "UPDATE employee SET name = '$name', email = '$email', dob = '$dob', gender = '$gender', faculty = '$faculty', salary = '$salary', phone = '$phone', address = '$address', status = '$status', photo = '$photo'" . $passwordSqlPart . " WHERE id = $id";
        } else {
            $updateSql = "UPDATE employee SET name = '$name', email = '$email', dob = '$dob', gender = '$gender', faculty = '$faculty', salary = '$salary', phone = '$phone', address = '$address', status = '$status'" . $passwordSqlPart . " WHERE id = $id";
        }

        if (mysqli_query($conn, $updateSql)) {
            $success = "Employee updated successfully.";

            $refreshSql = "SELECT * FROM employee WHERE id = $id";
            $refreshResult = mysqli_query($conn, $refreshSql);
            $employee = mysqli_fetch_assoc($refreshResult);
        } else {
            $error = "Unable to update employee.";
        }
    }
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Edit Employee</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="current_photo" value="<?php echo isset($employee["photo"]) ? $employee["photo"] : ""; ?>">
        <label>ID</label>
        <input type="text" value="<?php echo $employee["id"]; ?>" readonly>

        <label>Name</label>
        <input type="text" name="name" value="<?php echo $employee["name"]; ?>" placeholder="Enter full name" pattern="[A-Za-z][A-Za-z ]*" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $employee["email"]; ?>" placeholder="Enter email" required>

        <label>Password</label>
        <input type="password" name="password" value="" placeholder="Leave blank to keep same password" minlength="6" pattern="^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}$">

        <label>Date of Birth</label>
        <input type="date" name="dob" value="<?php echo $employee["dob"]; ?>" required>

        <label>Gender</label>
        <div class="inline-options">
            <input type="radio" name="gender" value="Male" id="eg_male" <?php if ($employee["gender"] === "Male") { echo "checked"; } ?>>
            <label for="eg_male">Male</label>
            <input type="radio" name="gender" value="Female" id="eg_female" <?php if ($employee["gender"] === "Female") { echo "checked"; } ?>>
            <label for="eg_female">Female</label>
            <input type="radio" name="gender" value="Other" id="eg_other" <?php if ($employee["gender"] === "Other") { echo "checked"; } ?>>
            <label for="eg_other">Other</label>
        </div>

        <label>Faculty</label>
        <select name="faculty" required>
            <option value="">Select faculty</option>
            <option value="CSIT" <?php if ($employee["faculty"] === "CSIT") { echo "selected"; } ?>>CSIT</option>
            <option value="BCS" <?php if ($employee["faculty"] === "BCS") { echo "selected"; } ?>>BCS</option>
            <option value="BBA" <?php if ($employee["faculty"] === "BBA") { echo "selected"; } ?>>BBA</option>
            <option value="BBM" <?php if ($employee["faculty"] === "BBM") { echo "selected"; } ?>>BBM</option>
        </select>

        <label>Salary</label>
        <input type="text" name="salary" value="<?php echo $employee["salary"]; ?>" placeholder="Enter salary" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?php echo $employee["phone"]; ?>" placeholder="Enter phone number" pattern="[0-9]+" required>

        <label>Current Photo</label>
        <?php if (isset($employee["photo"]) && $employee["photo"] !== "") { ?>
            <img src="../uploads/<?php echo $employee["photo"]; ?>" alt="photo" class="img-thumb">
        <?php } else { ?>
            <p>No photo uploaded.</p>
        <?php } ?>

        <label>Change Photo</label>
        <input type="file" name="photo" accept="image/*">

        <label>Address</label>
        <textarea name="address" rows="3" placeholder="Enter address"><?php echo $employee["address"]; ?></textarea>

        <label>Status</label>
        <select name="status">
            <option value="Active" <?php if ($employee["status"] === "Active") { echo "selected"; } ?>>Active</option>
            <option value="Inactive" <?php if ($employee["status"] === "Inactive") { echo "selected"; } ?>>Inactive</option>
        </select>

        <input type="submit" value="Update Employee">
    </form>
</div>
    </main>
</div>
</body>
</html>