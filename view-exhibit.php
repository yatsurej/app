<?php
    $pageTitle = "Web-AR";
    include 'header.php';
    include 'navbar.php';
    include 'db_connect.php';

    if (!isset($_SESSION['selectedEstablishment'])) {
        header('Location: index.php');
        exit();
    }

    $selectedEstablishment = $_SESSION['selectedEstablishment'];

    require_once('vendor/autoload.php');

    $clientID = "47852619874-gd8grjpupi6v2824afhlvm45mtbu8kvp.apps.googleusercontent.com";
    $secret   = "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";

    $gclient  = new Google_Client();

    $gclient->setClientId($clientID);
    $gclient->setClientSecret($secret);
    $gclient->setRedirectUri('http://localhost/app/view-exhibit.php');

    $gclient->addScope('email');
    $gclient->addScope('profile');

    if (isset($_GET['code'])) {
        $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

        if (!isset($token['error'])) {
            $gclient->setAccessToken($token['access_token']);

            $_SESSION['access_token'] = $token['access_token'];

            $gservice = new Google_Service_Oauth2($gclient);

            $udata = $gservice->userinfo->get();
            foreach ($udata as $key => $value) {
                echo $key . ': ' . $value . '<br>';
            }
            foreach ($udata as $k => $v) {
                $_SESSION['login_' . $k] = $v;
            }
            $_SESSION['ucode']      = $_GET['code'];
            $_SESSION['user_email'] = $udata->email;
            $_SESSION['profile']    = $udata->name;
            $_SESSION['id']         = $udata->id;
            header('location: view-exhibit.php');
            exit;
        }
    }
?>

<div class="container w-75 mt-4">
    <?php
    $galleryQuery  = "SELECT * FROM gallery WHERE establishmentCode = '$selectedEstablishment'";
    $galleryResult = mysqli_query($conn, $galleryQuery);

    while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
        $currentGalleryCode = $galleryRow['galleryCode'];
        $currentGalleryName = $galleryRow['galleryName'];

        $query = "SELECT e.*, m.locationTo, r.rackingName, SUM(m.actualCount) as totalActualCount
                  FROM exhibit e
                  INNER JOIN movement m ON e.exhibitID = m.exhibitID
                  LEFT JOIN racking r ON m.locationTo = r.rackingCode
                  LEFT JOIN gallery g ON r.galleryCode = g.galleryCode
                  WHERE g.establishmentCode = '$selectedEstablishment' AND e.isActive = 1 AND g.galleryCode = '$currentGalleryCode'
                  GROUP BY e.exhibitName, m.locationTo
                  HAVING totalActualCount = 1
                  ORDER BY totalActualCount DESC";

        $result = mysqli_query($conn, $query);

        $firstItem = true;

        if (mysqli_num_rows($result) > 0) {
            $carouselID = 'exhibitCarousel' . $currentGalleryCode;
    ?>
            <h2><?php echo $currentGalleryName; ?></h2>
            <div id="<?php echo $carouselID; ?>" class="carousel slide carousel-fade carousel-dark" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $exhibitID          = $row['exhibitID'];
                        $exhibitName        = $row['exhibitName'];
                        $exhibitModel       = $row['exhibitModel'];
                        $exhibitInformation = $row['exhibitInformation'];
                        $exhibitLocation    = $row['rackingName'];
                        
                        // View ratings
                        $ratingQuery    = "SELECT AVG(ratingScore) as averageRating, COUNT(feedbackID) as ratingCount
                                           FROM feedback
                                           WHERE exhibitID = '$exhibitID'";
                        $ratingResult   = mysqli_query($conn, $ratingQuery);
                        $ratingData     = mysqli_fetch_assoc($ratingResult);
                        $averageRating  = round($ratingData['averageRating'], 1);
                        $ratingCount    = $ratingData['ratingCount'];
                    ?>
                        <div class="carousel-item <?php echo $firstItem ? 'active' : ''; ?>">
                            <a href="#exhibitModal<?php echo $exhibitID; ?>" data-bs-toggle="modal" class="text-decoration-none" role="button">
                                <div class="card" style="width: 230px; margin: 0 auto;">
                                    <div class="card-header">
                                        <h5 class="card-title text-center"><?php echo $exhibitName; ?></h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <model-viewer
                                            src="<?php echo $exhibitModel ?>"
                                            camera-controls
                                            touch-action="pan-y"
                                            style="width: 100%; height: 150px; margin: 0 auto;">
                                        </model-viewer>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="modal fade" id="exhibitModal<?php echo $exhibitID; ?>" tabindex="-1" role="dialog" aria-labelledby="exhibitModalLabel<?php echo $exhibitID; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exhibitModalLabel<?php echo $exhibitID; ?>"><?php echo $exhibitName; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <model-viewer> tag -->
                                        <model-viewer ar src="<?php echo $exhibitModel ?>" camera-controls touch-action="pan-y" style="margin: 0 auto;"></model-viewer>
                                        <small class="d-block text-center text-muted fst-italic">Location: <?php echo $exhibitLocation ?></small>
                                        <!-- AR.js -->
                                        <div class="container text-end mb-2">
                                            <a href="scan.php?exhibitModel=<?php echo $exhibitModel; ?>" class="btn btn-dark">
                                                <i class="fa-solid fa-expand"></i>
                                                <span>
                                                    Scan Marker
                                                </span>
                                            </a>
                                        </div>
                                        <div class="container mb-2">
                                            <label for="exhibitInformation" class="form-label">Information</label>
                                            <textarea type="text" style="resize: none" class="form-control" rows="6" readonly><?php echo $exhibitInformation; ?></textarea>
                                        </div>
                                        
                                        <!-- Number of Ratings and Average score of Ratings -->
                                        <div class="text-center mb-2">
                                           <small>
                                                <?php echo $ratingCount; ?>
                                                <?php echo $ratingCount == 1 ? 'RATING' : 'RATINGS'; ?>
                                            </small>
                                            <br>
                                            <?php echo $averageRating; ?><br>
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $averageRating ? '<span class="fa-solid fa-star text-warning"></span>' : '<span class="fa-regular fa-star text-warning"></span>';
                                            }
                                            ?>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="text-center mt-3 me-1">
                                                <form method="post" action="reviews.php">
                                                    <input type="hidden" name="exhibitID" value="<?php echo $exhibitID; ?>">
                                                    <button type="submit" class="btn btn-dark ">
                                                        View Reviews
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="text-center">
                                                <?php if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) { ?>
                                                    <a type="button" class="btn btn-dark" href="<?= $gclient->createAuthUrl() ?>">Rate and Review</a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-dark sendRatingFeedbackButton" data-exhibit-id="<?php echo $exhibitID; ?>" data-bs-toggle="modal" data-bs-target="#sendRatingFeedback">
                                                        Rate and Review
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                        $firstItem = false;
                    }
                } 
                ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselID; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselID; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <br><br><br>
    <?php
        }
    ?>
</div>

<div class="modal fade" id="sendRatingFeedback" tabindex="-1" aria-labelledby="sendRatingFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendRatingFeedbackLabel">Rate and Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <input type="hidden" name="exhibitID" id="modalExhibitID" value="">
                    <input type="hidden" name="guestGoogleID" value="<?php echo $_SESSION['id']; ?>">
                    <input type="hidden" name="guestEmail" value="<?php echo $_SESSION['user_email']; ?>">

                    <div class="mb-3 text-center">
                        <label for="guestRating" class="form-label">Rating</label>
                        <div class="star-rating" id="star-rating">
                        </div>
                        <input type="hidden" name="guestRating" id="rating" value="1">
                    </div>
                    <div class="mb-1">
                        <input type="text" class="form-control" id="guestTitleFeedback" placeholder="Title" name="guestTitleFeedback">
                    </div>
                    <div class="mb-3">
                        <textarea type="text" style="resize: none" class="form-control" rows="5" id="guestFeedback" placeholder="Review (optional)" name="guestFeedback"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="sendRatingFeedback" class="btn btn-success">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const starContainer = document.getElementById('star-rating');
        const ratingInput = document.getElementById('rating');
        const feedbackButtons = document.querySelectorAll('.sendRatingFeedbackButton');
        const feedbackModal = new bootstrap.Modal(document.getElementById('sendRatingFeedback'));

        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('span');
            star.classList.add('fa-regular', 'fa-star', 'text-warning');
            star.setAttribute('data-rating', i);

            star.addEventListener('mouseover', function () {
                const rating = this.getAttribute('data-rating');
                highlightStars(rating);
            });

            star.addEventListener('mouseout', function () {
                const currentRating = ratingInput.value;
                highlightStars(currentRating);
            });

            star.addEventListener('click', function () {
                const rating = this.getAttribute('data-rating');
                ratingInput.value = rating;
            });

            starContainer.appendChild(star);
        }

        function highlightStars(count) {
            const stars = starContainer.children;
            for (let i = 0; i < stars.length; i++) {
                if (stars[i].getAttribute('data-rating') <= count) {
                    stars[i].classList.add('fa-solid');
                    stars[i].classList.remove('fa-regular');
                } else {
                    stars[i].classList.add('fa-regular');
                    stars[i].classList.remove('fa-solid');
                }
            }
        }

        feedbackButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const exhibitID = this.getAttribute('data-exhibit-id');
                document.getElementById('modalExhibitID').value = exhibitID;
                feedbackModal.show();
            });
        });
    });
</script>