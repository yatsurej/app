<?php
    $pageTitle = "Inventory";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';
    include 'i_nav.php';
?>
<div class="container w-50 my-3">
    <div class="container text-start text-muted fst-italic">
        Accession and Transfer of Exhibits
    </div>
    <div class="container text-end">
        <button class="btn btn-dark mb-2" href="#" data-bs-toggle="modal" data-bs-target="#addTransactionModal" role="button">
            Accession
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Location</th>
                    <th scope="col">Date</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $q= "SELECT movementCode, 
                        CONCAT(establishmentCode,' - ', galleryCode, ' - ', rackingCode) as Location, 
                        exhibitID,
                        movementDate, 
                        staffID 
                        FROM movement";
                    $r = mysqli_query($conn, $q);

                    while ($row = mysqli_fetch_assoc($r)) {
                        $transactionCode    = $row['movementCode'];
                        $location           = $row['Location'];
                        $exhibit            = $row['exhibitID'];
                        $date               = $row['movementDate'];
                        $staffID            = $row['staffID']

                        ?>
                    <tr>
                        <td class="text-center"><?php echo $transactionCode; ?></td>
                        <td class="text-center"><?php echo $exhibit; ?></td>
                        <td class="text-center"><?php echo $location; ?></td>
                        <td class="text-center"><?php echo $date; ?></td>
                        <td class="text-center"><?php echo $staffID; ?></td>
                        <td>
                            <div class="text-center">
                                <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#editTransactionModal<?php echo $transactionCode; ?>">
                                    Transfer
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editTransactionModal<?php echo $transactionCode; ?>" tabindex="-1" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaction</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="functions.php" method="post">
                                                <input type="hidden" name="transactionCode" value="<?php echo $transactionCode; ?>">
                                                
                                                <button type="submit" name="editTransaction" class="btn btn-primary">Save changes</button>
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

<!-- Add Transactions Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Exhibit Accession</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <div class="mb-3">
                        <label for="exhibitID" class="form-label">Exhibit</label>
                        <select class="form-select" id="exhibitID" name="exhibitID" required>
                            <?php
                                $exhibitsQuery = "SELECT ID, exhibitName FROM exhibits";
                                $exhibitsResult = mysqli_query($conn, $exhibitsQuery);

                                while ($exhibitsRow = mysqli_fetch_assoc($exhibitsResult)) {
                                    $exhibitID   = $exhibitsRow['ID'];
                                    $exhibitName = $exhibitsRow['exhibitName'];

                                    echo "<option value=\"$exhibitID\">$exhibitName</option>";
                                }
                            ?>
                        </select>
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
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <button type="submit" name="addTransaction" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#establishment").html('<option value="">Select Establishment</option>');
        $("#gallery").html('<option value="">Select Gallery</option>');
        $("#racking").html('<option value="">Select Racking</option>');

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

            if (establishmentCode){
                $("#gallery").html('<option value="">Select Gallery</option>');
                $("#racking").html('<option value="">Select Racking</option>');

                $("#gallery").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getGalleries: true, establishmentCode: establishmentCode },
                    success: function(data) {
                        $("#gallery").append(data);
                    }
                });
            }
        });

        $("#gallery").on("change", function() {
            var galleryCode = $(this).val();
            $("#galleryCode").val(galleryCode);

            if (galleryCode){
                $("#racking").html('<option value="">Select Racking</option>');
                $("#racking").prop("disabled", false);

                $.ajax({
                    url: "functions.php",
                    method: "POST",
                    data: { getRackings: true, galleryCode: galleryCode },
                    success: function(data) {
                        $("#racking").append(data);
                    }
                });
            }
        });

        $("#racking").on("change", function() {
            var rackingCode = $(this).val();
            $("#rackingCode").val(rackingCode);
        });
    });
</script>