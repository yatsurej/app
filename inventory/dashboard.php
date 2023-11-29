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
<div class="container w-50">
    <div class="container text-start text-muted fst-italic">
        List of Exhibits with their Location
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Exhibit Name</th>
                    <th scope="col">Current Location</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $q = "SELECT e.exhibitName, m.locationTo, SUM(m.actualCount) as totalActualCount
                    FROM exhibit e
                    INNER JOIN movement m ON e.exhibitID = m.exhibitID
                    GROUP BY e.exhibitName, m.locationTo
                    HAVING totalActualCount = 1
                    ORDER BY totalActualCount DESC";

                $r = mysqli_query($conn, $q);

                while ($row = mysqli_fetch_assoc($r)) {
                    $exhibit   = $row['exhibitName'];
                    $location  = $row['locationTo'];
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $exhibit; ?></td>
                        <td class="text-start"><?php echo $location; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
