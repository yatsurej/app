<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'i_nav.php';
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
                    $q= "SELECT * FROM movement_record";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $movementCode  = $row['movementCode'];
                        $movementType  = $row['movementType'];
                        $movementDate  = $row['movementDate'];
                        $movementFrom  = $row['movementFrom'];
                        $movementTo    = $row['movementTo'];

                        ?>
                    <tr>
                        <td class="text-center"><?php echo $movementCode; ?></td>
                        <td class="text-center"><?php echo $movementType; ?></td>
                        <td class="text-center"><?php echo $movementDate; ?></td>
                        <td class="text-center"><?php echo $movementFrom; ?></td>
                        <td class="text-center"><?php echo $movementTo; ?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>