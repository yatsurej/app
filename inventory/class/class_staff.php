<?php
    require '../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../db_connect.php';
    if (!class_exists('Staff')){
        class Staff {
            // login 
            public function login($username, $password){
                global $conn;
                $q  = "SELECT * FROM user WHERE username = '$username' AND password = '$password' AND isActive = 1";
                $r  = mysqli_query($conn, $q);

                if (mysqli_num_rows($r) > 0) {
                    $row = mysqli_fetch_assoc($r);
                    $role = $row['role'];
                    return $role;
                } else {
                    echo $conn->error;
                }
            }
            
            // recover password
            public function recover($username) {
                global $conn;
                
                $q  = "SELECT * FROM user WHERE username = '$username' AND isActive = 1";
                $r  = mysqli_query($conn, $q);

                if ($r && mysqli_num_rows($r) > 0) {
                    $row = mysqli_fetch_assoc($r);
                    return $row; 
                } else {
                    echo $conn->error;
                }
            }

            // send recovery email
            public function sendRecoveryEmail($email, $resetLink) {
                $mail = new PHPMailer(true);
                
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'froizelrej@gmail.com';
                    $mail->Password = '01n0l0p4';
                    $mail->addAddress($email);
                    $mail->Subject = 'Password Reset';
                    $mail->Body = "Click the following link to reset your password: $resetLink";
            
                    $mail->send();
                    return true;
                } catch (Exception $e) {
                    return false;
                }
            }

            // reset password
            public function resetPassword($userID, $newPassword) {
                global $conn;
                $q = "UPDATE user SET password = '$newPassword' WHERE userID = '$userID'";
                $r = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else{
                    echo $conn->error;
                }
            }

            // staff management
            public function addStaff($staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword){
                global $conn;
                $q  = "SELECT * FROM user WHERE username = '$staffUsername'";
                $r  = mysqli_query($conn, $q);
                
                if (mysqli_num_rows($r) > 0) {
                    echo "<script>alert('Username is already taken');window.location.href='/app/inventory/staff-list.php';</script>";
                } else {
                    global $conn;
                    $q  = "INSERT INTO user(firstName, lastName, contactNumber, username, password, role)
                           VALUES('$staffFirstName', '$staffLastName', '$staffContactNumber', '$staffUsername', '$staffPassword', 'Staff')";
                    $r  = mysqli_query($conn, $q);

                    if ($r){
                        return $conn;
                    } else{
                        echo $conn->error;
                    }
                }
            }
            public function editStaff($staffID, $staffUsername, $staffPassword, $staffStatus){
                global $conn;
                $q  = "UPDATE user 
                      SET username  = '$staffUsername', 
                      password      = '$staffPassword', 
                      isActive      = '$staffStatus' 
                      WHERE userID = $staffID";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }
            
            // profile editing
            public function editProfile($ID, $firstName, $lastName, $contactNumber, $username, $password){
                global $conn;
                $q = "UPDATE user
                     SET firstName = '$firstName', 
                     lastName      = '$lastName', 
                     contactNumber = '$contactNumber', 
                     username      = '$username', 
                     password      = '$password'
                     WHERE userID = $ID";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }

            // exhibit management
            public function addExhibit($exhibitName, $exhibitInformation, $exhibitModel) {
                global $conn;

                $latestCodeQuery = "SELECT MAX(CAST(SUBSTRING(exhibitCode, 2) AS SIGNED)) AS maxCode FROM exhibit";
                $result = mysqli_query($conn, $latestCodeQuery);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];

                    $nextExhibitCode = "E" . ($maxCode + 1);

                    $q = "INSERT INTO exhibit (exhibitCode, exhibitName, exhibitInformation, exhibitModel)
                                    VALUES ('$nextExhibitCode', '$exhibitName', '$exhibitInformation', '$exhibitModel')";
                    $q = mysqli_query($conn, $q);

                    if ($q) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }


            public function editExhibit($exhibitCode, $exhibitName, $exhibitInformation, $exhibitModel, $exhibitStatus){
                global $conn;

                $exhibitStatus = intval($exhibitStatus);

                $q  = "UPDATE exhibit SET exhibitName = '$exhibitName', 
                      exhibitInformation = '$exhibitInformation', 
                      exhibitModel = '$exhibitModel',
                      isActive = $exhibitStatus
                      WHERE exhibitCode = '$exhibitCode'";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }

            //establishment management
            public function addEstablishment($establishmentName) {
                global $conn;
            
                $latestCode = "SELECT MAX(CAST(SUBSTRING(establishmentCode, 5) AS SIGNED)) AS maxCode FROM establishment";
                $result = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextEstablishmentCode = "ESTB" . ($maxCode + 1);
            
                    $q = "INSERT INTO establishment(establishmentCode, establishmentName)
                          VALUES('$nextEstablishmentCode', '$establishmentName')";
                    $r = mysqli_query($conn, $q);
            
                    if ($r) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }
            public function editEstablishment($establishmentCode, $establishmentName, $establishmentStatus){
                global $conn;

                $establishmentStatus = intval($establishmentStatus);

                $q  = "UPDATE establishment SET establishmentName = '$establishmentName', 
                      isActive = $establishmentStatus
                      WHERE establishmentCode = '$establishmentCode'";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }

            // gallery management
            public function addGallery($establishmentCode, $galleryName) {
                global $conn;
            
                $latestCode = "SELECT MAX(CAST(SUBSTRING(galleryCode, 2) AS SIGNED)) AS maxCode FROM gallery";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "G" . ($maxCode + 1);
            
                    $q = "INSERT INTO gallery(galleryCode, establishmentCode, galleryName)
                          VALUES('$nextCode', '$establishmentCode', '$galleryName')";
                    $r = mysqli_query($conn, $q);
            
                    if ($r) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }
            public function editGallery($galleryCode, $establishmentCode, $galleryName, $galleryStatus){
                global $conn;

                $galleryStatus = intval($galleryStatus);

                $q  = "UPDATE gallery SET establishmentCode = '$establishmentCode',
                      galleryName = '$galleryName',
                      isActive = $galleryStatus
                      WHERE galleryCode = '$galleryCode'";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }

            // racking management
            public function addRacking($galleryCode, $rackingName) {
                global $conn;
            
                $latestCode = "SELECT MAX(CAST(SUBSTRING(rackingCode, 2) AS SIGNED)) AS maxCode FROM racking";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "R" . ($maxCode + 1);
            
                    $q = "INSERT INTO racking(rackingCode, galleryCode, rackingName)
                          VALUES('$nextCode', '$galleryCode', '$rackingName')";
                    $r = mysqli_query($conn, $q);
            
                    if ($r) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }
            public function editRacking($rackingCode, $galleryCode, $rackingName, $rackingStatus){
                global $conn;

                $rackingStatus = intval($rackingStatus);

                $q  = "UPDATE racking SET galleryCode = '$galleryCode',
                      rackingName = '$rackingName',
                      isActive = $rackingStatus
                      WHERE rackingCode = '$rackingCode'";
                $r  = mysqli_query($conn, $q);

                if ($r){
                    return $conn;
                } else {
                    echo $conn->error;
                }
            }
            
            // accession management
            public function addAccession($exhibitID, $rackingCode, $date, $staffID){
                global $conn;

                $latestCode = "SELECT MAX(CAST(SUBSTRING(accessionCode, 2) AS SIGNED)) AS maxCode FROM exhibit_accession";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "A" . ($maxCode + 1);
                    $q = "INSERT INTO exhibit_accession(accessionCode, rackingCode, exhibitID, accessionDate, userID)
                          VALUES('$nextCode', '$rackingCode', '$exhibitID', '$date', '$staffID')";
                    $r = mysqli_query($conn, $q);
            
                    if ($r) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }
            public function confirmAccessionPost($accessionCode){
                global $conn;

                $q = "UPDATE exhibit_accession 
                     SET isPosted = '1', datePosted = CURDATE()
                     WHERE accessionCode = '$accessionCode'";
                $r = mysqli_query($conn, $q);

                if($r){
                    return $conn;
                } else{
                    echo $conn->error;
                }
            }

            // transfer management
            public function addTransfer($exhibitID, $sourceRackingCode, $currentRackingCode, $date, $staffID){
                global $conn;

                $latestCode = "SELECT MAX(CAST(SUBSTRING(transferCode, 2) AS SIGNED)) AS maxCode FROM exhibit_transfer";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "T" . ($maxCode + 1);
                    $q = "INSERT INTO exhibit_transfer(transferCode, sourceRackingCode,  currentRackingCode, exhibitID, transferDate, userID)
                          VALUES('$nextCode', '$sourceRackingCode', '$currentRackingCode', '$exhibitID', '$date', '$staffID')";
                    $r = mysqli_query($conn, $q);
            
                    if ($r) {
                        return $conn;
                    } else {
                        echo $conn->error;
                    }
                } else {
                    echo $conn->error;
                }
            }
            public function confirmTransferPost($transferCode){
                global $conn;

                $q = "UPDATE exhibit_transfer 
                     SET isPosted = '1', datePosted = CURDATE()
                     WHERE transferCode = '$transferCode'";
                $r = mysqli_query($conn, $q);

                if($r){
                    return $conn;
                } else{
                    echo $conn->error;
                }
            }
        }
    }