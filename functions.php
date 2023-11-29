<?php
    require './class/class_user.php';
    $classUser   = new User;

    if (isset($_POST['sendFeedback'])){
        $exhibitID    = $_POST['exhibitID'];
        $userName     = $_POST['userProfile'];
        $userEmail    = $_POST['userEmail'];
        $userRating   = $_POST['userRating'];
        $userFeedback = $_POST['userFeedback'];
        $result       = $classUser->sendFeedback($exhibitID, $userName, $userEmail, $userRating, $userFeedback);
    
        if($result){
            header("Location: view-exhibit.php"); 
            exit();
        } else {
            echo "error";
        }
    } 