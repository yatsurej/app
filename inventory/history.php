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

    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    $filterCondition = ($filter == 'ACCESSION' || $filter == 'TRANSFER') ? " AND movementType = '$filter'" : '';

?>
<div class="container w-50 my-3">
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">History of exhibit movement</p>
        <form class="form-inline">
            <select class="custom-select my-1 mr-sm-2" name="filter" id="filter" onchange="this.form.submit()">
                <option value="" <?php echo ($filter == '') ? 'selected' : ''; ?>>All</option>
                <option value="ACCESSION" <?php echo ($filter == 'ACCESSION') ? 'selected' : ''; ?>>ACCESSION</option>
                <option value="TRANSFER" <?php echo ($filter == 'TRANSFER') ? 'selected' : ''; ?>>TRANSFER</option>
            </select>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Movement Code</th>
                    <th scope="col">Movement Type</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Location From</th>
                    <th scope="col">Location To</th>
                    <th scope="col">Date Posted</th>
                    <th scope="col">Modified By</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q = "SELECT movement.*, staff.firstName, staff.lastName, exhibit.exhibitName
                        FROM movement
                        JOIN staff ON movement.staffID = staff.staffID
                        JOIN exhibit ON movement.exhibitID = exhibit.exhibitID
                        WHERE actualCount = 1 $filterCondition
                        ORDER BY entryID DESC";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $movementCode  = $row['movementCode'];
                        $movementType  = $row['movementType'];
                        $exhibitName   = $row['exhibitName'];
                        $locationFrom  = ($movementType == "ACCESSION") ? "N/A" : $row['locationFrom'];
                        $locationTo    = $row['locationTo'];
                        $datePosted    = $row['datePosted'];
                        $firstName     = $row['firstName'];
                        $lastName      = $row['lastName'];
                        
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $movementCode; ?></td>
                        <td class="text-center"><?php echo $movementType; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center"><?php echo $locationFrom; ?></td>
                        <td class="text-center"><?php echo $locationTo; ?></td>
                        <td class="text-center"><?php echo $datePosted; ?></td>
                        <td class="text-center"><?php echo $firstName . ' ' . $lastName;?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>