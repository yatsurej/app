<?php
    require './class/class_user.php';
    $classUser   = new User;

    if (isset($_POST['sendFeedback'])){
        $userFeedback = $_POST['userFeedback'];
        $userEmail    = $_POST['userEmail'];
        $result       = $classUser->sendFeedback($userFeedback, $userEmail);
    
        if($result){
            header("Location: feedback.php"); 
            exit();
        } else {
            echo "error";
        }
    } 