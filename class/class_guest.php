<?php
    require './db_connect.php';

    if (!class_exists('Guest')) {
        class Guest {
            public function sendFeedback($exhibitID, $guestGoogleID, $guestEmail, $guestRating, $guestTitleFeedback, $guestFeedback) {
                global $conn;

                $checkGuestQuery = "SELECT guestID FROM guest WHERE guestGoogleEmail = '$guestEmail'";
                $checkGuestResult = $conn->query($checkGuestQuery);

                if ($checkGuestResult->num_rows > 0) {
                    $guestData = $checkGuestResult->fetch_assoc();
                    $guestID = $guestData['guestID'];
                } else {
                    $insertGuestQuery = "INSERT INTO guest(guestGoogleID, guestGoogleEmail) VALUES ('$guestGoogleID', '$guestEmail')";
                    $conn->query($insertGuestQuery);

                    $guestID = $conn->insert_id;
                }

                $insertFeedbackQuery = "INSERT INTO feedback(guestID, exhibitID, ratingScore, feedbackTitle, feedbackContent, feedbackDate)
                                    VALUES ('$guestID', '$exhibitID', '$guestRating', '$guestTitleFeedback', '$guestFeedback', CURDATE())";
                $conn->query($insertFeedbackQuery);

                return true;
            }
        }
    }
?>
