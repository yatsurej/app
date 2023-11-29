<?php
require './db_connect.php';

if (!class_exists('User')) {
    class User {
        public function sendFeedback($exhibitID, $userName, $userEmail, $userRating, $userFeedback) {
            global $conn;

            $checkUserQuery = "SELECT userID FROM user WHERE userEmail = '$userEmail'";
            $checkUserResult = $conn->query($checkUserQuery);

            if ($checkUserResult->num_rows > 0) {
                $userData = $checkUserResult->fetch_assoc();
                $userID = $userData['userID'];
            } else {
                $insertUserQuery = "INSERT INTO user(user_name, userEmail) VALUES ('$userName', '$userEmail')";
                $conn->query($insertUserQuery);

                $userID = $conn->insert_id;
            }

            $insertFeedbackQuery = "INSERT INTO feedback(userID, exhibitID, ratingScore, feedbackContent, feedbackDate)
                                   VALUES ('$userID', '$exhibitID', '$userRating', '$userFeedback', CURDATE())";
            $conn->query($insertFeedbackQuery);

            return true;
        }
    }
}
?>
