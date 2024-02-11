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

$postStatusFilter = isset($_GET['post_status']) ? $_GET['post_status'] : '';
$postStatusCondition = ($postStatusFilter == 'posted') ? 'AND isPosted = 1' : (($postStatusFilter == 'not_posted') ? 'AND isPosted = 0' : '');

$q = "SELECT exhibit_transfer.*, 
     establishment.establishmentName AS destEstablishmentName, 
     gallery.galleryName AS destGalleryName, 
     racking.rackingName AS destRackingName, 
     source_establishment.establishmentName AS sourceEstablishmentName, 
     source_gallery.galleryName AS sourceGalleryName, 
     source_racking.rackingName AS sourceRackingName, 
     exhibit.exhibitName, 
     user.firstName, 
     user.lastName
     FROM exhibit_transfer 
     LEFT JOIN racking ON exhibit_transfer.currentRackingCode = racking.rackingCode
     LEFT JOIN gallery ON racking.galleryCode = gallery.galleryCode
     LEFT JOIN establishment ON gallery.establishmentCode = establishment.establishmentCode
     LEFT JOIN racking AS source_racking ON exhibit_transfer.sourceRackingCode = source_racking.rackingCode
     LEFT JOIN gallery AS source_gallery ON source_racking.galleryCode = source_gallery.galleryCode
     LEFT JOIN establishment AS source_establishment ON source_gallery.establishmentCode = source_establishment.establishmentCode
     LEFT JOIN exhibit ON exhibit_transfer.exhibitID = exhibit.exhibitID
     LEFT JOIN user ON exhibit_transfer.userID = user.userID
     WHERE 1 $postStatusCondition
     ORDER BY ID DESC";

$r = mysqli_query($conn, $q);
?>

<div class="container w-75">
    <div class="container d-flex justify-content-between align-items-center text-muted fst-italic">
        <p class="text-muted fst-italic">Management of exhibit transfer</p>
        <button class="btn btn-dark mb-1" data-bs-toggle="modal" data-bs-target="#addTransferModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Transfer</span>
        </button>
    </div>

    <div class="d-flex justify-content-end">
        <form class="form-inline">
            <select class="custom-select mr-3" name="post_status" id="post_status" onchange="this.form.submit()">
                <option value="" <?php echo ($postStatusFilter == '') ? 'selected' : ''; ?>>All</option>
                <option value="posted" <?php echo ($postStatusFilter == 'posted') ? 'selected' : ''; ?>>Posted</option>
                <option value="not_posted" <?php echo ($postStatusFilter == 'not_posted') ? 'selected' : ''; ?>>Not Posted</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Source<small class="d-block text-muted fst-italic">establishment - gallery - racking</small></th>
                    <th scope="col">Location<small class="d-block text-muted fst-italic">establishment - gallery - racking</small></th>
                    <th scope="col">Transfer Date</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($r)) {
                    $transferCode           = $row['transferCode'];
                    $sourceLocation         = $row['sourceRackingCode'];
                    $destEstablishmentName  = $row['destEstablishmentName'];
                    $destGalleryName        = $row['destGalleryName'];
                    $destRackingName        = $row['destRackingName'];
                    $sourceEstablishmentName= $row['sourceEstablishmentName'];
                    $sourceGalleryName      = $row['sourceGalleryName'];
                    $sourceRackingName      = $row['sourceRackingName'];
                    $exhibitName            = $row['exhibitName'];
                    $staffFirstName         = $row['firstName'];
                    $staffLastName          = $row['lastName'];
                    $transferDate           = $row['transferDate'];
                    $posted                 = $row['isPosted'];

                    $postStatus = ($posted == 1) ? "Posted" : "Not Posted";
                ?>
                    <tr>
                        <td class="text-center"><?php echo $transferCode; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center"><?php echo $sourceEstablishmentName . ' - ' . $sourceGalleryName . ' - ' . $sourceRackingName; ?></td>
                        <td class="text-center"><?php echo $destEstablishmentName . ' - ' . $destGalleryName . ' - ' . $destRackingName; ?><br></td>
                        <td class="text-center"><?php echo $transferDate; ?></td>
                        <td class="text-center"><?php echo $staffFirstName . ' ' . $staffLastName; ?></td>
                        <td class="text-center"><?php echo $postStatus; ?></td>
                        <td>
                            <div class="text-center">
                                <?php if ($postStatus == "Not Posted") { ?>
                                    <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#postConfirmationModal<?php echo $transferCode; ?>">
                                        <i class="fa-solid fa-arrow-up"></i>
                                        <span>Post</span>
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-dark mb-2" disabled>
                                        <i class="fa-solid fa-check"></i>
                                        <span>Posted</span>
                                    </button>
                                <?php } ?>
                            </div>

                            <!-- Post Confirmation Modal -->
                            <div class="modal fade" id="postConfirmationModal<?php echo $transferCode; ?>" tabindex="-1" aria-labelledby="postConfirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="postConfirmationModalLabel">Post Transfer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="functions.php" method="post">
                                            <input type="hidden" name="transferCode" value="<?php echo $transferCode; ?>">
                                            <div class="modal-body">
                                                <p>Are you sure you want to post this Transfer?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success" name="confirmPostTransfer">Submit</button>
                                            </div>
                                        </form>
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
$transferExhibit = '';
?>

<!-- Add Transfer Modal -->
<div class="modal fade" id="addTransferModal" tabindex="-1" aria-labelledby="addTransferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransferModalLabel">Exhibit Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="exhibitID" class="form-label">Exhibit</label>
                        <select class="form-select" id="exhibitID" name="exhibitID" required>
                            <option value="" <?php echo ($transferExhibit == '') ? 'selected' : ''; ?>>Select exhibit</option>
                            <?php
                            $query = "SELECT e.exhibitID, e.exhibitName
                                     FROM exhibit e
                                     INNER JOIN exhibit_accession a ON e.exhibitID = a.exhibitID
                                     WHERE e.isActive = 1 AND a.isPosted = 1";

                            $result = mysqli_query($conn, $query);

                            while ($exhibitsRow = mysqli_fetch_assoc($result)) {
                                $exhibitID         = $exhibitsRow['exhibitID'];
                                $exhibitName       = $exhibitsRow['exhibitName'];

                                $selected = ($exhibitID == '') ? 'selected' : 'Select exhibit';

                                echo "<option value=\"$exhibitID\" $selected>$exhibitName</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="humanReadableLocation">Source Location<small class="d-block text-muted fst-italic">establishment - gallery - racking</small></label>
                        <input class="form-control" type="text" id="humanReadableLocation" name="humanReadableLocation" readonly>
                    </div>
                    <input type="hidden" id="sourceLocation" name="sourceLocation">
                    <hr style="height:1px;border-width:0;color:gray;background-color:gray">

                    <div class="text-center">
                        <label for="">Destination</label>
                    </div>
                    <div class="mb-3">
                        <label for="establishment">Establishment</label>
                        <select class="form-control" id="establishment" name="establishment" required>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="establishmentCode" name="establishmentCode">

                    <div class="mb-3">
                        <label for="gallery">Gallery</label>
                        <select class="form-control" id="gallery" name="gallery" required disabled>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="galleryCode" name="galleryCode">

                    <div class="mb-3">
                        <label for="racking">Racking</label>
                        <select class="form-control" id="racking" name="racking" required disabled>
                            <option value=""></option>
                        </select>
                    </div>
                    <input type="hidden" id="rackingCode" name="rackingCode">

                    <div class="mb-3">
                        <label for="date">Transfer Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <input type="hidden" name="staffID" value="<?php echo $_SESSION['userID']; ?>">

                    <div class="text-end">
                        <button type="submit" name="addTransfer" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#establishment").html('<option value="">Select establishment destination</option>');
        $("#gallery").html('<option value="">Select gallery destination</option>');
        $("#racking").html('<option value="">Select racking destination</option>');

        $.ajax({
            url: "functions.php",
            method: "POST",
            data: { getEstablishments: true },
            success: function (data) {
                $("#establishment").append(data);
            }
        });

        $("#establishment").on("change", function () {
            var establishmentCode = $(this).val();
            $("#establishmentCode").val(establishmentCode);

            if (establishmentCode) {
                $("#gallery").html('<option value="">Select gallery destination</option>');
                $("#gallery").prop("disabled", true);

                $("#racking").html('<option value="">Select racking destination</option>');
                $("#racking").prop("disabled", true);

                $("#gallery").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getGalleries: true, establishmentCode: establishmentCode },
                    success: function (data) {
                        $("#gallery").append(data);
                    }
                });
            } else {
                $("#gallery").html('<option value="">Select gallery destination</option>');
                $("#gallery").prop("disabled", true);

                $("#racking").html('<option value="">Select racking destination</option>');
                $("#racking").prop("disabled", true);
            }
        });

        $("#gallery").on("change", function() {
            var galleryCode = $(this).val();
            $("#galleryCode").val(galleryCode);

            if (galleryCode) {
                $("#racking").html('<option value="">Select racking destination</option>');
                $("#racking").prop("disabled", true); 

                $("#racking").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getRackings: true, galleryCode: galleryCode },
                    success: function(data) {
                        $("#racking").append(data);
                    }
                });
            } else {
                $("#racking").html('<option value="">Select racking destination</option>');
                $("#racking").prop("disabled", true);
            }
        });

        $("#racking").on("change", function() {
            var rackingCode = $(this).val();
            $("#rackingCode").val(rackingCode);
        });

        $('#sourceLocation').val('Select exhibit first');
        $('#humanReadableLocation').val('Select exhibit first');
        $('#exhibitID').change(function () {
            var selectedExhibitID = $(this).val();
            if (selectedExhibitID !== '') {
                $.ajax({
                    url: 'functions.php',
                    type: 'POST',
                    data: { exhibitID: selectedExhibitID },
                    dataType: 'json',
                    success: function (data) {
                        if (data && !data.error) {
                            $('#humanReadableLocation').val(data.humanReadable);
                            $('#sourceLocation').val(data.rackingCode);
                        } else {
                            $('#humanReadableLocation').val('Error fetching source location.');
                            $('#sourceLocation').val('');
                        }
                    },
                    error: function () {
                        $('#humanReadableLocation').val('Error fetching source location.');
                        $('#sourceLocation').val('');
                    }
                });
            } else {
                $('#humanReadableLocation').val('Select exhibit first');
                $('#sourceLocation').val('');
            }
        });
    });
</script>