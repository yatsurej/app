<?php
session_start();

if (!isset($_SESSION['user_authenticated'])) {
    header('Location: ./login.php');
    exit();
}


$pageTitle = "Inventory";
include '../header.php';
include 'navbar.php';
include '../db_connect.php';
include 'i_nav.php';
?>

you are logged in