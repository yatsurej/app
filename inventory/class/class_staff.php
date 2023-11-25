<?php
    require '../db_connect.php';
    if (!class_exists('Staff')){
        class Staff {
            // login 
            public function login($username, $password){
                global $conn;
                $q  = "SELECT * FROM staff WHERE username = '$username' AND password = '$password' AND isActive = 1";
                $r  = mysqli_query($conn, $q);

                if (mysqli_num_rows($r) > 0) {
                    $row = mysqli_fetch_assoc($r);
                    $role = $row['role'];
                    return $role;
                } else {
                    echo $conn->error;
                }
            }

            // staff management
            public function addStaff($staffFirstName, $staffLastName, $staffContactNumber, $staffUsername, $staffPassword){
                global $conn;
                $q  = "SELECT * FROM staff WHERE username = '$staffUsername'";
                $r  = mysqli_query($conn, $q);
                
                if (mysqli_num_rows($r) > 0) {
                    echo "<script>alert('Username is already taken');window.location.href='/app/inventory/staff-list.php';</script>";
                } else {
                    global $conn;
                    $q  = "INSERT INTO staff(firstName, lastName, contactNumber, username, password, role)
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
                $q  = "UPDATE staff 
                      SET username  = '$staffUsername', 
                      password      = '$staffPassword', 
                      isActive      = '$staffStatus' 
                      WHERE staffID = $staffID";
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
                $q = "UPDATE staff
                     SET firstName = '$firstName', 
                     lastName      = '$lastName', 
                     contactNumber = '$contactNumber', 
                     username      = '$username', 
                     password      = '$password'
                     WHERE staffID = $ID";
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
            
                $latestCode = "SELECT MAX(SUBSTRING(exhibitCode, 2)) AS maxCode FROM exhibits";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextExhibitCode = "E" . ($maxCode + 1);
            
                    $q = "INSERT INTO exhibits(exhibitCode, exhibitName, exhibitInformation, exhibitModel)
                          VALUES('$nextExhibitCode', '$exhibitName', '$exhibitInformation', '$exhibitModel')";
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

            public function editExhibit($exhibitCode, $exhibitName, $exhibitInformation, $exhibitModel, $exhibitStatus){
                global $conn;

                $exhibitStatus = intval($exhibitStatus);

                $q  = "UPDATE exhibits SET exhibitName = '$exhibitName', 
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
            
                $latestCode = "SELECT MAX(SUBSTRING(establishmentCode, 5)) AS maxCode FROM establishment";
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
            
                $latestCode = "SELECT MAX(SUBSTRING(galleryCode, 2)) AS maxCode FROM gallery";
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
            
                $latestCode = "SELECT MAX(SUBSTRING(rackingCode, 2)) AS maxCode FROM racking";
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
            public function addAccession($exhibitID, $establishmentCode, $galleryCode, $rackingCode, $date, $staffID){
                global $conn;

                $latestCode = "SELECT MAX(SUBSTRING(accessionCode, 2)) AS maxCode FROM accession";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "A" . ($maxCode + 1);
                    $q = "INSERT INTO accession(accessionCode, establishmentCode, galleryCode, rackingCode, exhibitID, accessionDate, staffID)
                          VALUES('$nextCode', '$establishmentCode', '$galleryCode', '$rackingCode', '$exhibitID', '$date', '$staffID')";
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

                $q = "UPDATE accession 
                     SET posted = '1', datePosted = CURDATE()
                     WHERE accessionCode = '$accessionCode'";
                $r = mysqli_query($conn, $q);

                if($r){
                    return $conn;
                } else{
                    echo $conn->error;
                }
            }

            // transfer management
            public function addTransfer($exhibitID, $sourceLocation, $establishmentCode, $galleryCode, $rackingCode, $date, $staffID){
                global $conn;

                $latestCode = "SELECT MAX(SUBSTRING(transferCode, 2)) AS maxCode FROM transfer";
                $result     = mysqli_query($conn, $latestCode);
            
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $maxCode = $row['maxCode'];
            
                    $nextCode = "T" . ($maxCode + 1);
                    $q = "INSERT INTO transfer(transferCode, sourceLocation, establishmentCode, galleryCode, rackingCode, exhibitID, transferDate, staffID)
                          VALUES('$nextCode', '$sourceLocation', '$establishmentCode', '$galleryCode', '$rackingCode', '$exhibitID', '$date', '$staffID')";
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

                $q = "UPDATE transfer 
                     SET posted = '1', datePosted = CURDATE()
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