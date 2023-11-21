<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'i_nav.php';

    $_SESSION['last_active_page'] = basename(__FILE__);

    if (isset($_SESSION['username'])) {
        $username    = $_SESSION['username'];
        $staffQuery  = "SELECT * FROM staff WHERE username = '$username'";
        $staffResult = mysqli_query($conn, $staffQuery);

        while($staffRow = mysqli_fetch_assoc($staffResult)){
            $staffID    = $staffRow['staffID'];

            $_SESSION['staffID'] = $staffID;
        }
    } else {
        header('Location: index.php');
        exit();
    }
?>
<div class="container w-50 my-3">
    <div class="container text-start text-muted fst-italic">
        Exhibit Movement History
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Movement Code</th>
                    <th scope="col">Movement Type</th>
                    <th scope="col">Location From</th>
                    <th scope="col">Location To</th>
                    <th scope="col">Modified By</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT movement.*, staff.firstName, staff.lastName
                        FROM movement
                        JOIN staff ON movement.staffID = staff.staffID";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $movementCode  = $row['movementCode'];
                        $movementType  = $row['movementType'];
                        $locationFrom  = $row['locationFrom'];
                        $locationTo    = $row['locationTo'];
                        $firstName     = $row['firstName'];
                        $lastName      = $row['lastName'];
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $movementCode; ?></td>
                        <td class="text-center"><?php echo $movementType; ?></td>
                        <td class="text-center"><?php echo $locationFrom; ?></td>
                        <td class="text-center"><?php echo $locationTo; ?></td>
                        <td class="text-center"><?php echo $firstName . ' ' . $lastName;?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>