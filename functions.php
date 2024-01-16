<?php
    require './class/class_guest.php';
    $classGuest   = new Guest;

    if (isset($_POST['sendRatingFeedback'])){
        $exhibitID          = $_POST['exhibitID'];
        $guestGoogleID      = $_POST['guestGoogleID'];
        $guestEmail         = $_POST['guestEmail'];
        $guestRating        = $_POST['guestRating'];
        $guestTitleFeedback = $_POST['guestTitleFeedback'];
        $guestFeedback      = $_POST['guestFeedback'];

        $result             = $classGuest->sendFeedback($exhibitID, $guestGoogleID, $guestEmail, $guestRating, $guestTitleFeedback, $guestFeedback);
    
        if($result){
            header("Location: view-exhibit.php"); 
            exit();
        } else {
            echo "error";
        }
    } 