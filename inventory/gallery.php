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

    $establishmentFilter = isset($_GET['establishment_filter']) ? $_GET['establishment_filter'] : '';

    $q = "SELECT gallery.*, establishment.establishmentName 
          FROM gallery 
          JOIN establishment ON gallery.establishmentCode = establishment.establishmentCode
          WHERE establishment.establishmentCode = '$establishmentFilter' OR '$establishmentFilter' = ''
          ORDER BY ID ASC
          LIMIT $offset, $recordsPerPage";
    $r = mysqli_query($conn, $q);
?>

<div class="container w-75">
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of gallery</p>
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addGalleryModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Gallery</span>
        </button>
    </div>
    <div class="d-flex justify-content-end">
        <form class="form-inline" method="GET">
            <select class="custom-select mr-3" name="establishment_filter" id="establishment_filter" onchange="this.form.submit()">
                <option value="" <?php echo ($establishmentFilter == '') ? 'selected' : ''; ?>>All</option>
                <?php
                    $establishmentQuery = "SELECT establishmentCode, establishmentName FROM establishment";
                    $establishmentResult = mysqli_query($conn, $establishmentQuery);

                    while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
                        $establishmentCode = $establishmentRow['establishmentCode'];
                        $establishmentName = $establishmentRow['establishmentName'];

                        $selected = ($establishmentFilter == $establishmentCode) ? 'selected' : '';

                        echo "<option value=\"$establishmentCode\" $selected>$establishmentName</option>";
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
                        $galleryCode        = $row['galleryCode'];
                        $galleryName        = $row['galleryName'];
                        $establishmentName  = $row['establishmentName'];
                        $galleryStatus      = $row['isActive'];

                        $statusText = ($galleryStatus == 1) ? "Active" : "Inactive";
                ?>
                    <tr>
                        <td class="text-center"><?php echo $galleryCode; ?></td>
                        <td class="text-center"><?php echo $galleryName; ?></td>
                        <td class="text-center"><?php echo $establishmentName ; ?></td>
                        <td class="text-center"><?php echo $statusText; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#editGalleryModal<?php echo $galleryCode; ?>">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editGalleryModal<?php echo $galleryCode; ?>" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editGalleryModalLabel">Edit Gallery</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="galleryCode" value="<?php echo $galleryCode; ?>">
                                                <div class="mb-3">
                                                    <label for="establishmentCode" class="form-label">Select Establishment</label>
                                                    <select class="form-select" id="establishmentCode" name="establishmentCode" required>
                                                        <?php
                                                            $establishmentQuery = "SELECT establishmentCode, establishmentName FROM establishment";
                                                            $establishmentResult = mysqli_query($conn, $establishmentQuery);

                                                            while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
                                                                $currentEstablishmentCode = $establishmentRow['establishmentCode'];
                                                                $currentEstablishmentName = $establishmentRow['establishmentName'];

                                                                $selected = ($currentEstablishmentCode == $row['establishmentCode']) ? "selected" : "";

                                                                echo "<option value=\"$currentEstablishmentCode\" $selected>$currentEstablishmentName</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="galleryName" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="galleryName" name="galleryName" value="<?php echo $galleryName; ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="galleryStatus" class="form-label">Status</label>
                                                    <select class="form-select" id="galleryStatus" name="galleryStatus">
                                                        <option value="1" <?php echo ($galleryStatus == 1) ? "selected" : ""; ?>>Active</option>
                                                        <option value="0" <?php echo ($galleryStatus == 0) ? "selected" : ""; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="text-end">
                                                    <button type="submit" name="editGallery" class="btn btn-success">Save changes</button>
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
    $totalPages = ceil(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gallery")) / $recordsPerPage);
?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i . '&establishment_filter=' . $establishmentFilter; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>

<?php
    $selectedEstablishment = '';
?>

<!-- Add Gallery Modal -->
<div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addGalleryModalLabel">Add gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="establishmentCode" class="form-label">Select Establishment</label>
                        <select class="form-select" id="establishmentCode" name="establishmentCode" required>
                            <option value="" <?php echo ($selectedEstablishment == '') ? 'selected' : ''; ?>>Select establishment</option>
                            <?php
                                $establishmentQuery = "SELECT establishmentCode, establishmentName FROM establishment";
                                $establishmentResult = mysqli_query($conn, $establishmentQuery);

                                while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
                                    $establishmentCode = $establishmentRow['establishmentCode'];
                                    $establishmentName = $establishmentRow['establishmentName'];

                                    echo "<option value=\"$establishmentCode\">$establishmentName</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="galleryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="galleryName" name="galleryName" placeholder="Enter gallery name" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="addGallery" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
