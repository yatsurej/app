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
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of exhibit</p>
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addExhibitModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Exhibit</span>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Information</th>
                    <th scope="col">Model</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT * FROM exhibit";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $exhibitCode        = $row['exhibitCode'];
                        $exhibitName        = $row['exhibitName'];
                        $exhibitInformation = $row['exhibitInformation'];
                        $exhibitModel       = $row['exhibitModel'];
                        $exhibitStatus      = $row['isActive'];

                        $statusText = ($exhibitStatus == 1) ? "Active" : "Inactive";
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $exhibitCode; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center"><?php echo $exhibitInformation; ?></td>
                        <td class="text-center"><?php echo $exhibitModel; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editExhibitModal<?php echo $exhibitCode; ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editExhibitModal<?php echo $exhibitCode; ?>" tabindex="-1" aria-labelledby="editExhibitModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editExhibitModalLabel">Edit Exhibit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="exhibitCode" value="<?php echo $exhibitCode; ?>">
                                                <div class="mb-3">
                                                    <label for="exhibitName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="exhibitName" name="exhibitName" value="<?php echo $exhibitName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exhibitInformation" class="form-label">Information</label>
                                                    <textarea type="text" class="form-control" rows="5" id="exhibitInformation" name="exhibitInformation"><?php echo $exhibitInformation; ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exhibitModel" class="form-label">Model</label>
                                                    <input type="text" class="form-control" id="exhibitModel" name="exhibitModel" value="<?php echo $exhibitModel; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exhibitStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="exhibitStatus" name="exhibitStatus">
                                                        <option value="1" <?php echo ($exhibitStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($exhibitStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" name="editExhibit" class="btn btn-success">Save changes</button>
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

<!-- Add Exhibits Modal -->
<div class="modal fade" id="addExhibitModal" tabindex="-1" aria-labelledby="addExhibitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExhibitModalLabel">Add Exhibit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="exhibitName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exhibitName" name="exhibitName" placeholder="Enter exhibit name" required>
                    </div>
                    <div class="mb-3">
                        <label for="exhibitInformation" class="form-label">Information</label>
                        <textarea type="text" class="form-control" rows="5" id="exhibitInformation" placeholder="Enter exhibit's information" name="exhibitInformation" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exhibitModel" class="form-label">Model</label>
                        <input type="text" class="form-control" id="exhibitModel" name="exhibitModel" placeholder="Enter exhibit's 3D model url" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addExhibit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>