<?php
    session_start();

    if (!isset($_SESSION['user_authenticated'])) {
        header('Location: login.php');
        exit();
    }
    include '../db_connect.php';
    $username    = $_SESSION['username'];
    $staffQuery  = "SELECT * FROM user WHERE username = '$username'";
    $staffResult = mysqli_query($conn, $staffQuery);

    while($staffRow = mysqli_fetch_assoc($staffResult)){
        $staffID        = $staffRow['userID'];
        $staffFirstName = $staffRow['firstName'];
        $staffLastName  = $staffRow['lastName'];    
    }
    $pageTitle = "Inventory";
    include '../header.php';
    include '../db_connect.php';
    include 'navbar.php';
?>
<style>
    img{
        width: 80%;
    }
</style>
<div class="container w-50 text-center mt-5">
    <p class="fs-3">Welcome, 
        <?php 
            if ($_SESSION['user_role'] == 'Admin') {
                echo "Admin ";
            } elseif ($_SESSION['user_role'] == 'Staff') {
                echo "Staff ";
            } else {
                echo "Unknown Role";
            }
            echo $staffFirstName . ' ' . $staffLastName;
            if ($_SESSION['user_role'] == 'Admin') {
                echo '<img src="../images/admin.gif" alt="">';
            } elseif ($_SESSION['user_role'] == 'Staff') {
                echo '<img src="../images/staff.gif" alt="">';
            } 
        ?>
    </p>
</div>
