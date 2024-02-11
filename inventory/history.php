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

    $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
    $filterCondition = ($filter == 'ACCESSION' || $filter == 'TRANSFER') ? " AND movementType = '$filter'" : '';

    // For table pages
    $itemsPerPage = 10;

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    $q = "SELECT movement.*, user.firstName, user.lastName, exhibit.exhibitName
        FROM movement
        JOIN exhibit ON movement.exhibitID = exhibit.exhibitID
        JOIN user ON movement.userID = user.userID
        WHERE actualCount = 1 $filterCondition
        ORDER BY entryID DESC
        LIMIT $offset, $itemsPerPage";

    $r = mysqli_query($conn, $q);

    // Fetch total records for pagination
    $totalRecordsQuery = "SELECT COUNT(*) AS totalRecords
                          FROM movement
                          JOIN exhibit ON movement.exhibitID = exhibit.exhibitID
                          JOIN user ON movement.userID = user.userID
                          WHERE actualCount = 1 $filterCondition";

    $totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
    $totalRecordsRow = mysqli_fetch_assoc($totalRecordsResult);
    $totalRecords = $totalRecordsRow['totalRecords'];

    // Calculate total pages
    $totalPages = ceil($totalRecords / $itemsPerPage);
?>
<div class="container w-75 my-3">
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
                    <th scope="col">Exhibit Name</th>
                    <th scope="col">Location From</th>
                    <th scope="col">Location <br>To</th>
                    <th scope="col">Date Posted</th>
                    <th scope="col">Modified By</th>
                </tr>
            </thead>
            <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($r)) {
                    $movementCode  = $row['movementCode'];
                    $movementType  = $row['movementType'];
                    $exhibitName   = $row['exhibitName'];
                    $locationFrom  = ($movementType == "ACCESSION") ? "N/A" : $row['locationFrom'];
                    $locationTo    = $row['locationTo'];
                    $datePosted    = $row['datePosted'];
                    $firstName     = $row['firstName'];
                    $lastName      = $row['lastName'];

                    // Details for locationTo
                    $detailsQueryTo = "SELECT rackingName, galleryName, establishmentName
                                        FROM racking
                                        LEFT JOIN gallery ON racking.galleryCode = gallery.galleryCode
                                        LEFT JOIN establishment ON gallery.establishmentCode = establishment.establishmentCode
                                        WHERE racking.rackingCode = '$locationTo'";

                    $detailsResultTo = mysqli_query($conn, $detailsQueryTo);
                    $detailsTo = mysqli_fetch_assoc($detailsResultTo);

                    $rackingNameTo = isset($detailsTo['rackingName']) ? $detailsTo['rackingName'] : 'N/A';
                    $galleryNameTo = isset($detailsTo['galleryName']) ? $detailsTo['galleryName'] : 'N/A';
                    $establishmentNameTo = isset($detailsTo['establishmentName']) ? $detailsTo['establishmentName'] : 'N/A';

                    // Details for locationFrom
                    $detailsQueryFrom = "SELECT rackingName, galleryName, establishmentName
                                            FROM racking
                                            LEFT JOIN gallery ON racking.galleryCode = gallery.galleryCode
                                            LEFT JOIN establishment ON gallery.establishmentCode = establishment.establishmentCode
                                            WHERE racking.rackingCode = '$locationFrom'";

                    $detailsResultFrom = mysqli_query($conn, $detailsQueryFrom);
                    $detailsFrom = mysqli_fetch_assoc($detailsResultFrom);

                    $rackingNameFrom = isset($detailsFrom['rackingName']) ? $detailsFrom['rackingName'] : 'N/A';
                    $galleryNameFrom = isset($detailsFrom['galleryName']) ? $detailsFrom['galleryName'] : 'N/A';
                    $establishmentNameFrom = isset($detailsFrom['establishmentName']) ? $detailsFrom['establishmentName'] : 'N/A';

                    ?>
                    <tr>
                        <td class="text-center"><?php echo $movementCode; ?></td>
                        <td class="text-center"><?php echo $movementType; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center">
                            <?php
                            echo ($movementType == "ACCESSION")
                                ? $locationFrom
                                : ($establishmentNameFrom . ' - ' . $galleryNameFrom . ' - ' . $rackingNameFrom);
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            echo ($rackingNameTo !== 'N/A')
                                ? ($establishmentNameTo . ' - ' . $galleryNameTo . ' - ' . $rackingNameTo)
                                : 'N/A';
                            ?>
                        </td>
                        <td class="text-center"><?php echo $datePosted; ?></td>
                        <td class="text-center"><?php echo $firstName . ' ' . $lastName; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap Pagination -->
<div class="container w-75">
    <nav aria-label="exhibit table page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                <li class="page-item <?php echo ($page == $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
