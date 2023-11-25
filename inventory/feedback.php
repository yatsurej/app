<?php
    $pageTitle = "Feedback List";
    include '../header.php';
    include 'navbar.php';
    include '../db_connect.php';

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
    <h1 class="text-start fw-bold mt-4">Feedback List</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="container d-flex justify-content-between align-items-center">
        <p class="text-muted fst-italic">Records of User Feedbacks</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-center">
                <tr>
                    <th scope="col">User's Name</th>
                    <th scope="col">Rating Score</th>
                    <th scope="col">Feedback Content</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT feedbacks.*, user.userFirstName, user.userLastName
                    FROM feedbacks 
                    JOIN user ON feedbacks.userID = user.userID";
                $r = mysqli_query($conn, $q);

                while ($row = mysqli_fetch_assoc($r)) {
                    $userFirstName       = $row['userFirstName'];
                    $userLastName        = $row['userLastName'];
                    $userRating          = $row['ratingScore'];
                    $userFeedback        = $row['feedbackContent'];
                    ?>
                    <tr>
                        <td class="text-center"> <?php
                            $fullName = ($userFirstName && $userLastName) ? $userFirstName . ' ' . $userLastName : "N/A";
                            echo $fullName;
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $userRating) {
                                    echo '<i class="fa-solid fa-star text-warning"></i>';
                                } else {
                                    echo '<i class="fa-regular fa-star text-warning"></i>';
                                }
                            }
                            ?>
                        </td>
                        <td class="text-center"><?php echo $userFeedback; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>