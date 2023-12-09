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
        <p class="text-muted fst-italic">Management of exhibit transfer</p>
        <button class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#addTransferModal" role="button">
            <i class="fa-solid fa-plus"></i>
            <span class="ms-2">Add Transfer</span>
        </button>
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
                    $q = "SELECT exhibit_transfer.*, establishment.establishmentName, gallery.galleryName, racking.rackingName, exhibit.exhibitName, staff.firstName, staff.lastName
                    FROM exhibit_transfer 
                    LEFT JOIN establishment ON exhibit_transfer.establishmentCode = establishment.establishmentCode
                    LEFT JOIN gallery ON exhibit_transfer.galleryCode = gallery.galleryCode
                    LEFT JOIN racking ON exhibit_transfer.rackingCode = racking.rackingCode
                    LEFT JOIN exhibit ON exhibit_transfer.exhibitID = exhibit.exhibitID
                    LEFT JOIN staff ON exhibit_transfer.staffID = staff.staffID
                    ORDER BY ID DESC";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $transferCode         = $row['transferCode'];
                        $sourceLocation       = $row['sourceLocation'];
                        $establishmentName    = $row['establishmentName'];
                        $galleryName          = $row['galleryName'];
                        $rackingName          = $row['rackingName'];
                        $exhibitName          = $row['exhibitName'];
                        $staffFirstName       = $row['firstName'];
                        $staffLastName        = $row['lastName'];
                        $transferDate         = $row['transferDate'];
                        $posted               = $row['posted'];

                        $postStatus = ($posted == 1) ? "Posted" : "Not Posted";
                ?>
                    <tr>
                        <td class="text-center"><?php echo $transferCode; ?></td>
                        <td class="text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center"><?php echo $sourceLocation; ?></td>
                        <td class="text-center"><?php echo $establishmentName . ' -<br>' . $galleryName . ' -<br>' . $rackingName; ?></td>
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
                                         WHERE e.isActive = 1 AND a.posted = 1";

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
                        <label for="sourceLocation">Source Location<small class="d-block text-muted fst-italic">establishment - gallery - racking</small></label>
                        <input class="form-control" type="text" id="sourceLocation" name="sourceLocation" readonly>
                    </div>
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
                    <input type="hidden" name="staffID" value="<?php echo $_SESSION['staffID']; ?>">

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
    $(document).ready(function() {
        $("#establishment").html('<option value="">Select establishment destination</option>');
        $("#gallery").html('<option value="">Select gallery destination</option>');
        $("#racking").html('<option value="">Select racking destination</option>');

        $.ajax({
            url: "functions.php",
            method: "POST",
            data: { getEstablishments: true },
            success: function(data) {
                $("#establishment").append(data);
            }
        });

        $("#establishment").on("change", function() {
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
                    success: function(data) {
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
        $('#exhibitID').change(function () {
            var selectedExhibitID = $(this).val();
            if (selectedExhibitID !== '') {
                $.ajax({
                    url: 'functions.php',
                    type: 'POST',
                    data: { exhibitID: selectedExhibitID },
                    success: function (data) {
                        $('#sourceLocation').val(data);
                    },
                    error: function () {
                        $('#sourceLocation').val('Error fetching source location.');
                    }
                });
            } else {
            $('#sourceLocation').val('Select exhibit first');
            }
        });
    });
</script>