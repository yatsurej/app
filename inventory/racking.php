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

    $recordsPerPage = 10; 
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $recordsPerPage;

    $galleryFilter = isset($_GET['gallery_filter']) ? $_GET['gallery_filter'] : '';

    $q = "SELECT racking.*, gallery.galleryName 
          FROM racking 
          JOIN gallery ON racking.galleryCode = gallery.galleryCode
          WHERE gallery.galleryCode = '$galleryFilter' OR '$galleryFilter' = ''
          ORDER BY ID ASC
          LIMIT $offset, $recordsPerPage";
    $r = mysqli_query($conn, $q);
?>

<div class="container w-75">

    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of racking</p>
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addRackingModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Racking</span>
        </button>
    </div>
    <div class="d-flex justify-content-end">
        <form class="form-inline" method="GET">
            <select class="custom-select mr-3" name="gallery_filter" id="gallery_filter" onchange="this.form.submit()">
                <option value="" <?php echo ($galleryFilter == '') ? 'selected' : ''; ?>>All</option>
                <?php
                    $galleryQuery = "SELECT galleryCode, galleryName FROM gallery";
                    $galleryResult = mysqli_query($conn, $galleryQuery);
    
                    while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
                        $galleryCode = $galleryRow['galleryCode'];
                        $galleryName = $galleryRow['galleryName'];
    
                        $selected = ($galleryFilter == $galleryCode) ? 'selected' : '';
    
                        echo "<option value=\"$galleryCode\" $selected>$galleryName</option>";
                    }
                ?>
            </select>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_assoc($r)) {
                        $rackingCode        = $row['rackingCode'];
                        $rackingName        = $row['rackingName'];
                        $galleryName        = $row['galleryName'];
                        $rackingStatus      = $row['isActive'];

                        $statusText = ($rackingStatus == 1) ? "Active" : "Inactive";
                ?>
                    <tr>
                        <td class="text-center"><?php echo $rackingCode; ?></td>
                        <td class="text-center"><?php echo $rackingName; ?></td>
                        <td class="text-center"><?php echo $galleryName ; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editRackingModal<?php echo $rackingCode; ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editRackingModal<?php echo $rackingCode; ?>" tabindex="-1" aria-labelledby="editRackingModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editRackingModalLabel">Edit Racking</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="rackingCode" value="<?php echo $rackingCode; ?>">
                                                <div class="mb-3">
                                                    <label for="galleryCode" class="form-label">Select Gallery</label>
                                                    <select class="form-select" id="galleryCode" name="galleryCode" required>
                                                        <?php
                                                            $galleryQuery = "SELECT galleryCode, galleryName FROM gallery";
                                                            $galleryResult = mysqli_query($conn, $galleryQuery);

                                                            while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
                                                                $currentGalleryCode = $galleryRow['galleryCode'];
                                                                $currentGalleryName = $galleryRow['galleryName'];

                                                                $selected = ($currentGalleryCode == $row['galleryCode']) ? "selected" : "";

                                                                echo "<option value=\"$currentGalleryCode\" $selected>$currentGalleryName</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rackingName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="rackingName" name="rackingName" value="<?php echo $rackingName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="rackingStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="rackingStatus" name="rackingStatus">
                                                        <option value="1" <?php echo ($rackingStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($rackingStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" name="editRacking" class="btn btn-success">Save changes</button>
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

<?php
    $selectedGallery = '';
?>

<!-- Add Racking Modal -->
<div class="modal fade" id="addRackingModal" tabindex="-1" aria-labelledby="addRackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRackingModalLabel">Add Racking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="galleryCode" class="form-label">Select Gallery</label>
                        <select class="form-select" id="galleryCode" name="galleryCode" required>
                            <option value="" <?php echo ($selectedGallery == '') ? 'selected' : ''; ?>>Select gallery</option>
                            <?php
                                $galleryQuery = "SELECT galleryCode, galleryName FROM gallery";
                                $galleryResult = mysqli_query($conn, $galleryQuery);

                                while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
                                    $galleryCode = $galleryRow['galleryCode'];
                                    $galleryName = $galleryRow['galleryName'];

                                    echo "<option value=\"$galleryCode\">$galleryName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rackingName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="rackingName" name="rackingName" placeholder="Enter racking name" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="addRacking" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $totalPages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM racking")) / $recordsPerPage);
?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i . '&gallery_filter=' . $galleryFilter; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>