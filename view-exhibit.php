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
    $secret = "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";

    $gclient = new Google_Client();

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
            foreach ($udata as $k => $v) {
                $_SESSION['login_' . $k] = $v;
            }
            $_SESSION['ucode'] = $_GET['code'];
            $_SESSION['user_email'] = $udata->email;
            $_SESSION['profile'] = $udata->name;
            header('location: view-exhibit.php');
            exit;
        }
    }
?>
<div class="container w-50 mt-4">
    <?php
    $galleryQuery = "SELECT * FROM gallery WHERE establishmentCode = '$selectedEstablishment'";
    $galleryResult = mysqli_query($conn, $galleryQuery);

    $carouselCounter = 1;

    while ($galleryRow = mysqli_fetch_assoc($galleryResult)) {
        $currentGalleryCode = $galleryRow['galleryCode'];
        $currentGalleryName = $galleryRow['galleryName'];

        $carouselID = 'exhibitCarousel' . $carouselCounter;
        $carouselCounter++;
    ?>
        <h2><?php echo $currentGalleryName; ?></h2>
        <div id="<?php echo $carouselID; ?>" class="carousel slide carousel-fade carousel-dark" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                    $query = "SELECT e.*, m.locationTo, SUM(m.actualCount) as totalActualCount
                            FROM exhibit e
                            INNER JOIN movement m ON e.exhibitID = m.exhibitID
                            WHERE m.locationTo LIKE '%$currentGalleryName%' AND e.isActive = 1
                            GROUP BY e.exhibitName, m.locationTo
                            HAVING totalActualCount = 1
                            ORDER BY totalActualCount DESC";
                    $result = mysqli_query($conn, $query);

                    $firstItem = true;

                    while ($row = mysqli_fetch_assoc($result)) {
                        $exhibitID          = $row['exhibitID'];
                        $exhibitName        = $row['exhibitName'];
                        $exhibitModel       = $row['exhibitModel'];
                        $exhibitInformation = $row['exhibitInformation'];
                        $exhibitLocation    = $row['locationTo'];
                ?>
                    <div class="carousel-item <?php echo $firstItem ? 'active' : ''; ?>">
                        <a href="#exhibitModal<?php echo $exhibitID; ?>" data-bs-toggle="modal" class="text-decoration-none" role="button">
                            <div class="card" style="width: 200px; margin: 0 auto;">
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
                    <div class="modal fade" id="exhibitModal<?php echo $exhibitID; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exhibitModalLabel<?php echo $exhibitID; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exhibitModalLabel<?php echo $exhibitID; ?>"><?php echo $exhibitName; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <model-viewer
                                        ar
                                        src="<?php echo $exhibitModel ?>"
                                        camera-controls
                                        touch-action="pan-y">
                                    </model-viewer>
                                    <small class="d-block text-center text-muted fst-italic">Location: <?php echo $exhibitLocation?></small>
                                    <p>Information: <br>&emsp;  <?php echo $exhibitInformation; ?></p>

                                    <div class="container text-center mb-5">
                                        <a href="scan.php?exhibitModel=<?php echo $exhibitModel; ?>" class="btn btn-dark">
                                            <i class="fa-solid fa-expand"></i>
                                            <span>
                                                Scan Marker
                                            </span>
                                        </a>
                                    </div>

                                    <?php 
                                    if(!$_SESSION['access_token']){?>
                                    <div class="container text-center">
                                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#googleLoginModal">Rate</button>
                                    </div>
                                    <?php } else{ ?>
                                    <div class="container text-center">
                                        <button type="button" class="btn btn-dark sendRatingFeedbackButton" data-exhibit-id="<?php echo $exhibitID; ?>" data-bs-toggle="modal" data-bs-target="#sendRatingFeedback">Rate</button>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $firstItem = false;
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
        <br>
        <br>
        <br>
    <?php
    }
    ?>
</div>

<div class="modal fade" id="sendRatingFeedback" tabindex="-1" aria-labelledby="sendRatingFeedbackLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendRatingFeedbackLabel">Send Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <input type="hidden" name="exhibitID" id="modalExhibitID" value="">
                    <input type="hidden" name="userProfile" value="<?php echo $_SESSION['profile']; ?>">
                    <input type="hidden" name="userEmail" value="<?php echo $_SESSION['user_email']; ?>">

                    <div class="mb-3">
                        <label for="userRating" class="form-label">Rating</label>
                        <div class="star-rating" id="star-rating">
                        </div>
                        <input type="hidden" name="userRating" id="rating" value="1">
                    </div>
                    <div class="mb-3">
                        <label for="userFeedback" class="form-label">Feedback</label>
                        <textarea type="text" class="form-control" rows="5" id="userFeedback" placeholder="Write down your feedback (optional)" name="userFeedback"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="sendRatingFeedback" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="googleLoginModal" tabindex="-1" aria-labelledby="googleLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <a class="button" href="<?= $gclient->createAuthUrl() ?>">Login with google</a>
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
