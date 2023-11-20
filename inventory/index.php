<?php
    session_start();

    if (!isset($_SESSION['user_authenticated'])) {
        header('Location: login.php');
        exit();
    }
    include '../db_connect.php';
    $username    = $_SESSION['username'];
    $staffQuery  = "SELECT * FROM staff WHERE username = '$username'";
    $staffResult = mysqli_query($conn, $staffQuery);

    while($staffRow = mysqli_fetch_assoc($staffResult)){
        $staffID        = $staffRow['staffID'];
        $staffFirstName = $staffRow['firstName'];
        $staffLastName  = $staffRow['lastName'];    
    }
    $pageTitle = "Inventory";
    include '../header.php';
    include '../db_connect.php';
    include 'navbar.php';
?>

<div class="container w-50 text-center mt-5">
    <p>Welcome, 
        <?php 
            if ($_SESSION['user_role'] == 'Admin') {
                echo "Admin ";
            } elseif ($_SESSION['user_role'] == 'Staff') {
                echo "Staff ";
            } else {
                echo "Unknown Role";
            }
            echo $staffFirstName . ' ' . $staffLastName;
        ?>
    </p>
</div>
