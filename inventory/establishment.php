<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'i_nav.php';

    $_SESSION['last_active_page'] = basename(__FILE__);

    if (isset($_SESSION['username'])) {
        $username    = $_SESSION['username'];
        $staffQuery  = "SELECT * FROM user WHERE username = '$username'";
        $staffResult = mysqli_query($conn, $staffQuery);

        while($staffRow = mysqli_fetch_assoc($staffResult)){
            $staffID    = $staffRow['userID'];

            $_SESSION['userID'] = $staffID;
        }
    } else {
        header('Location: index.php');
        exit();
    }
?>
<div class="container w-50">
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of establishment</p>
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addEstablishmentModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Establishment</span>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT * FROM establishment";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $establishmentCode        = $row['establishmentCode'];
                        $establishmentName        = $row['establishmentName'];
                        $establishmentStatus      = $row['isActive'];

                        $statusText = ($establishmentStatus == 1) ? "Active" : "Inactive";
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $establishmentCode; ?></td>
                        <td class="text-center"><?php echo $establishmentName; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editEstablishmentModal<?php echo $establishmentCode; ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editEstablishmentModal<?php echo $establishmentCode; ?>" tabindex="-1" aria-labelledby="editEstablishmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editEstablishmentModalLabel">Edit Establishment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="establishmentCode" value="<?php echo $establishmentCode; ?>">
                                                <div class="mb-3">
                                                    <label for="establishmentName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="establishmentName" name="establishmentName" value="<?php echo $establishmentName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="establishmentStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="establishmentStatus" name="establishmentStatus">
                                                        <option value="1" <?php echo ($establishmentStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($establishmentStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" name="editEstablishment" class="btn btn-success">Save changes</button>
                                                </div>  
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Establishment Modal -->
<div class="modal fade" id="addEstablishmentModal" tabindex="-1" aria-labelledby="addEstablishmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEstablishmentModalLabel">Add Establishment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="establishmentName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="establishmentName" name="establishmentName" placeholder="Enter establishment name" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addEstablishment" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>