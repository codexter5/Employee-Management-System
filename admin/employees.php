<?php
include "../includes/functions.php";
include "../config/db.php";
requireRole("Admin");

$pageTitle = "View Employee";
$search = "";

if (isset($_GET["search"])) {
    $search = cleanData($_GET["search"]);
}

if ($search !== "") {
    $sql = "SELECT * FROM employee WHERE id LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%' OR faculty LIKE '%$search%' ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT * FROM employee ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
}

$success = getMessage("success");
$error = getMessage("error");

include "../includes/header.php";
?>
<div class="card">
    <h2>View Employee</h2>

    <?php if ($success !== "") { ?>
        <div class="alert success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if ($error !== "") { ?>
        <div class="alert error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="get" action="" class="search-row">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search by id, name, email, or faculty">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>DOB</th>
            <th>Gender</th>
            <th>Faculty</th>
            <th>Salary</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td>
                    <?php if (isset($row["photo"]) && $row["photo"] !== "") { ?>
                        <img src="../uploads/<?php echo $row["photo"]; ?>" alt="photo" class="img-thumb">
                    <?php } else { ?>
                        <img src="../uploads/default.png" alt="default photo" class="img-thumb">
                    <?php } ?>
                </td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td><?php echo $row["dob"]; ?></td>
                <td><?php echo $row["gender"]; ?></td>
                <td><?php echo $row["faculty"]; ?></td>
                <td><?php echo $row["salary"]; ?></td>
                <td><?php echo $row["phone"]; ?></td>
                <td><?php echo $row["address"]; ?></td>
                <td><?php echo $row["status"]; ?></td>
                <td class="actions">
                    <a href="edit_employee.php?id=<?php echo $row["id"]; ?>" class="btn-edit">Edit</a>
                    <a href="delete_employee.php?id=<?php echo $row["id"]; ?>" class="btn-delete">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
    </main>
</div>
</body>
</html>