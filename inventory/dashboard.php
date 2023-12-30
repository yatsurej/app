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

        while ($staffRow = mysqli_fetch_assoc($staffResult)) {
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

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $q = "SELECT e.exhibitName, m.locationTo, r.rackingName, g.galleryName, est.establishmentName, SUM(m.actualCount) as totalActualCount
        FROM exhibit e
        INNER JOIN movement m ON e.exhibitID = m.exhibitID
        LEFT JOIN racking r ON m.locationTo = r.rackingCode
        LEFT JOIN gallery g ON r.galleryCode = g.galleryCode
        LEFT JOIN establishment est ON g.establishmentCode = est.establishmentCode
        WHERE e.isActive = 1 AND (e.exhibitName LIKE '%$search%' OR m.locationTo LIKE '%$search%' OR r.rackingName LIKE '%$search%' OR g.galleryName LIKE '%$search%' OR est.establishmentName LIKE '%$search%')
        GROUP BY e.exhibitName, m.locationTo
        HAVING totalActualCount = 1
        ORDER BY e.exhibitName
        LIMIT $offset, $recordsPerPage";

    $r = mysqli_query($conn, $q);
?>

<div class="container w-50">
    <div class="container text-start text-muted fst-italic">
        List of Exhibits with their location
    </div>
    <div class="d-flex justify-content-end mr-3">
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="<?php echo $search; ?>">
                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
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
                    while ($row = mysqli_fetch_assoc($r)) {
                        $exhibit           = $row['exhibitName'];
                        $location          = $row['locationTo'];
                        $rackingName       = $row['rackingName'];
                        $galleryName       = $row['galleryName'];
                        $establishmentName = $row['establishmentName'];
                ?>
                        <tr>
                            <td class="text-center"><?php echo $exhibit; ?></td>
                            <td class="text-start"><?php echo $establishmentName . ' - ' . $galleryName . ' - ' . $rackingName; ?></td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    $totalPages = ceil(mysqli_num_rows(mysqli_query($conn, $q)) / $recordsPerPage);
?>
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1 . '&search=' . $search; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i . '&search=' . $search; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1 . '&search=' . $search; ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
