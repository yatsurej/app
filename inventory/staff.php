<?php
    $pageTitle = "Staff List";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';

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
    <h1 class="text-start fw-bold mt-4">Staff List</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="container d-flex justify-content-between align-items-center">
        <p class="text-muted fst-italic">Management of Staff Accounts</p>
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addStaffModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Staff</span>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT * FROM staff WHERE role = 'Staff' ";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $staffID             = $row['staffID'];
                        $staffFirstName      = $row['firstName'];
                        $staffLastName       = $row['lastName'];
                        $staffContactNumber  = $row['contactNumber'];
                        $staffUsername       = $row['username'];
                        $staffPassword       = $row['password'];
                        $staffStatus         = $row['isActive'];

                        $statusText = ($staffStatus == 1) ? "Active" : "Inactive";
                        ?>
                    <tr>
                        <td class="text-center"><?php echo $staffFirstName . ' ' . $staffLastName; ?></td>
                        <td class="text-center"><?php echo $staffContactNumber; ?></td>
                        <td class="text-center"><?php echo $staffUsername; ?></td>
                        <td class="text-center"><?php echo $staffPassword; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                        <div class="text-center">
                            <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#editStaffModal<?php echo $staffID; ?>">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                            </button>
                        </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editStaffModal<?php echo $staffID; ?>" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="staffID" value="<?php echo $staffID; ?>">
                                                <div class="mb-3">
                                                    <label for="staffUsername" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="staffUsername" name="staffUsername" value="<?php echo $staffUsername; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="staffPassword" class="form-label">Password</label>
                                                    <input type="text" class="form-control" id="staffPassword" name="staffPassword" value="<?php echo $staffPassword; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="staffStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="staffStatus" name="staffStatus">
                                                        <option value="1" <?php echo ($staffStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($staffStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" name="editStaff" class="btn btn-primary">Save changes</button>
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

<!-- Add Staffs Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStaffModalLabel">Add Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="staffFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="staffFirstName" name="staffFirstName" placeholder="Enter staff's first name" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="staffLastName" name="staffLastName" placeholder="Enter staff's last name" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffContactNo" class="form-label">Contact Number</label>
                        <input type="number" class="form-control" id="staffContactNo" name="staffContactNo" placeholder="Enter staff's contact number" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="staffUsername" name="staffUsername" placeholder="Enter staff's username" required>
                    </div>
                    <div class="mb-3">
                        <label for="staffPassword" class="form-label">Password</label>
                        <input type="text" class="form-control" id="staffPassword" name="staffPassword" placeholder="Enter staff's password" required>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="addStaff" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>