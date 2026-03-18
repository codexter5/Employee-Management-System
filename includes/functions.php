<?php
session_start();

function cleanData($data)
{
    return htmlspecialchars(trim($data));
}

function setMessage($type, $message)
{
    $_SESSION["flash_" . $type] = $message;
}

function getMessage($type)
{
    $key = "flash_" . $type;
    if (isset($_SESSION[$key])) {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $message;
    }

    return "";
}

function isLoggedIn()
{
    return isset($_SESSION["role"]);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit();
    }
}

function requireRole($role)
{
    requireLogin();
    if ($_SESSION["role"] !== $role) {
        header("Location: ../index.php");
        exit();
    }
}

function goToDashboardByRole()
{
    if (!isLoggedIn()) {
        return;
    }

    if ($_SESSION["role"] === "Admin") {
        header("Location: admin/dashboard.php");
        exit();
    }

    header("Location: employee/dashboard.php");
    exit();
}
?>

