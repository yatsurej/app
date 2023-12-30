<?php
    $pageTitle = "Feedback List";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';

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
?>
<div class="container w-50">
    <h1 class="text-start fw-bold mt-4">Feedback List</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="container d-flex justify-content-between align-items-center">
        <p class="text-muted fst-italic">Records of Guest Feedbacks</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">Guest's Name</th>
                    <th scope="col">Exhibit Name</th>
                    <th scope="col">Rating Score</th>
                    <th scope="col">Feedback Content</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT feedback.*, guest.guestGoogleID, exhibit.exhibitName
                    FROM feedback 
                    LEFT JOIN exhibit ON feedback.exhibitID = exhibit.exhibitID
                    LEFT JOIN guest ON feedback.guestID = guest.guestID";
                $r = mysqli_query($conn, $q);

                while ($row = mysqli_fetch_assoc($r)) {
                    $guestGoogleID        = $row['guestGoogleID'];
                    $exhibitName          = $row['exhibitName'];
                    $guestRating          = $row['ratingScore'];
                    $guestFeedback        = $row['feedbackContent'];
                    ?>
                    <tr>
                        <td class="text-center"> <?php echo $guestGoogleID;?></td>
                        <td class= "text-center"><?php echo $exhibitName; ?></td>
                        <td class="text-center">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $guestRating) {
                                    echo '<i class="fa-solid fa-star text-warning"></i>';
                                } else {
                                    echo '<i class="fa-regular fa-star text-warning"></i>';
                                }
                            }
                            ?>
                        </td>
                        <td class="text-center"><?php echo $guestFeedback; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>