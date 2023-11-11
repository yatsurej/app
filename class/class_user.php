<?php
require './db_connect.php';
    if (!class_exists('User')){
        class User{
            public function sendFeedback($userFeedback, $userEmail){
                $db = mysqli_connect('localhost', 'root', '', 'webar');
                $q  = "INSERT INTO feedbacks(content, sender)
                        VALUES('$userFeedback', '$userEmail')";
                $r  = mysqli_query($db, $q);

                if ($r){
                    return $db;
                } else{
                    echo $db->error;
                }
            }
        }
    }