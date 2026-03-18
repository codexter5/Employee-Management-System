<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "Add Employee";
$error = "";
$success = getMessage("success");

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
    $photo = "";
    $photoColumnExists = false;

    $colCheck = mysqli_query($conn, "SHOW COLUMNS FROM employee LIKE 'photo'");
    if ($colCheck && mysqli_num_rows($colCheck) > 0) {
        $photoColumnExists = true;
    }

    if ($name === "" || $email === "" || $password === "" || $dob === "" || $gender === "" || $faculty === "" || $salary === "" || $phone === "") {
        $error = "Please fill required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!is_numeric($salary)) {
        $error = "Salary must be a number.";
    } elseif (!is_numeric($phone)) {
        $error = "Phone must be numbers only.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($photoColumnExists && isset($_FILES["photo"]) && $_FILES["photo"]["name"] !== "") {
            $photo = cleanData($_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], "../uploads/" . $photo);
        }

        if ($photoColumnExists) {
            $sql = "INSERT INTO employee (name, email, password, dob, gender, faculty, salary, phone, address, status, photo) VALUES ('$name', '$email', '$hashedPassword', '$dob', '$gender', '$faculty', '$salary', '$phone', '$address', '$status', '$photo')";
        } else {
            $sql = "INSERT INTO employee (name, email, password, dob, gender, faculty, salary, phone, address, status) VALUES ('$name', '$email', '$hashedPassword', '$dob', '$gender', '$faculty', '$salary', '$phone', '$address', '$status')";
        }

        if (mysqli_query($conn, $sql)) {
            setMessage("success", "Employee added successfully.");
            header("Location: add_employee.php");
            exit();
        } else {
            $error = "Unable to add employee.";
        }
    }
}

include "../includes/header.php";
?>
<div class="card">
    <h2>Add Employee</h2>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" placeholder="Enter full name" pattern="[A-Za-z][A-Za-z ]*" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter password" minlength="6" pattern="^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}$" required>

        <label>Date of Birth</label>
        <input type="date" name="dob" required>

        <label>Gender</label>
        <div class="inline-options">
            <input type="radio" name="gender" value="Male" id="g_male">
            <label for="g_male">Male</label>
            <input type="radio" name="gender" value="Female" id="g_female">
            <label for="g_female">Female</label>
            <input type="radio" name="gender" value="Other" id="g_other">
            <label for="g_other">Other</label>
        </div>

        <label>Faculty</label>
        <select name="faculty" required>
            <option value="">Select faculty</option>
            <option value="CSIT">CSIT</option>
            <option value="BCS">BCS</option>
            <option value="BBA">BBA</option>
            <option value="BBM">BBM</option>
        </select>

        <label>Salary</label>
        <input type="text" name="salary" placeholder="Enter salary" required>

        <label>Phone</label>
        <input type="text" name="phone" placeholder="Enter phone number" pattern="[0-9]+" required>

        <label>Photo</label>
        <input type="file" name="photo" accept="image/*">

        <label>Address</label>
        <textarea name="address" rows="3" placeholder="Enter address"></textarea>

        <label>Status</label>
        <select name="status">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>

        <div class="button-row">
            <input type="submit" value="Save Employee">
            <input type="reset" value="Clear">
        </div>
    </form>
</div>
    </main>
</div>
</body>
</html>