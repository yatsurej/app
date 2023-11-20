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
                    <th scope="col">Type</th>
                    <th scope="col">Date</th>
                    <th scope="col">Location From</th>
                    <th scope="col">Location To</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // $q= "SELECT * FROM movement_record";
                    // $r = mysqli_query($conn, $q);

                    // while ($row = mysqli_fetch_assoc($r)) {
                    //     $movementCode  = $row['movementCode'];
                    //     $movementType  = $row['movementType'];
                    //     $movementDate  = $row['movementDate'];
                    //     $movementFrom  = $row['movementFrom'];
                    //     $movementTo    = $row['movementTo'];

                        ?>
                    <tr>
                        <td class="text-center"><?php echo "to be edited"; ?></td>
                        <td class="text-center"><?php echo "to be edited"; ?></td>
                        <td class="text-center"><?php echo "to be edited"; ?></td>
                        <td class="text-center"><?php echo "to be edited"; ?></td>
                        <td class="text-center"><?php echo "to be edited";?></td>
                    </tr>
                <?php
                    // }
                ?>
            </tbody>
        </table>
    </div>
</div>