<?php
$pageTitle = "Web-AR";
include 'header.php';
include 'navbar.php';
include 'db_connect.php';

$exhibitID = $_POST['exhibitID'];
$exhibitQuery = "SELECT * FROM exhibit WHERE exhibitID = '$exhibitID'";
$exhibitResult = mysqli_query($conn, $exhibitQuery);

if ($exhibitRow = mysqli_fetch_assoc($exhibitResult)) {
    $exhibitName = $exhibitRow['exhibitName'];
}
?>
<div class="container w-75">
    <a href="view-exhibit.php" type="button" class="btn btn-dark mb-1 mt-3">
        <i class="fa-solid fa-arrow-left"></i>        
        <span>Back</span>
    </a>
    <h1 class="text-start fw-bold mt-3 fs-4 fs-md-3 fs-lg-1">Reviews of <?php echo $exhibitName; ?></h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php
        $hasReviews = false; // Flag to check if there are reviews

        if (isset($exhibitID)) {
            $feedbackQuery = "SELECT * FROM feedback WHERE exhibitID = '$exhibitID'";
            $feedbackResult = mysqli_query($conn, $feedbackQuery);
    
            while ($feedbackRow = mysqli_fetch_assoc($feedbackResult)) {
                $hasReviews = true; // Set the flag to true
                $feedbackTitle   = $feedbackRow['feedbackTitle'];
                $feedbackContent = $feedbackRow['feedbackContent'];
                $feedbackRating  = $feedbackRow['ratingScore'];
                $feedbackDate    = $feedbackRow['feedbackDate'];
        ?>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $feedbackTitle; ?></h5>
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $feedbackRating) {
                                        echo '<i class="fa-solid fa-star text-warning"></i>';
                                    } else {
                                        echo '<i class="fa-regular fa-star text-warning"></i>';
                                    }
                                }
                                ?>
                                <p class="card-text"><?php echo $feedbackContent; ?></p>
                                <small class="text-muted fst-italic"><?php echo $feedbackDate ?></small>
                            </div>
                        </div>
                    </div>
        <?php
            }
        }
        ?>
    </div>
    <?php
    if (!$hasReviews) {
        echo '<p class="text-center text-muted mt-5">No reviews available.</p>';
    }
    ?>
</div>
