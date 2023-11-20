public function confirmPost($accessionCode){
                global $conn;

                $q = "UPDATE accession SET posted = '1'
                     WHERE accessionCode = '$accessionCode'";
                $r = mysqli_query($conn, $q);

                if($r){
                    return $conn;
                } else{
                    echo $conn->error;
                }
            }

            elseif (isset($_POST['transferGetEstablishments'])) {
        $options = '';
        
        $q = "SELECT establishmentCode, establishmentName FROM establishment";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['establishmentCode']}'>{$row['establishmentName']}</option>";
        }
        echo $options;
        exit; 
    } elseif (isset($_POST['transferGetGalleries']) && isset($_POST['establishmentCode'])) {
        $establishmentCode = $_POST['establishmentCode'];
        $options = '';

        $q = "SELECT galleryCode, galleryName FROM gallery WHERE establishmentCode = '$establishmentCode'";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['galleryCode']}'>{$row['galleryName']}</option>";
        }
        echo $options;
        exit;
    } elseif (isset($_POST['transferGetRackings']) && isset($_POST['galleryCode'])) {
        $galleryCode = $_POST['galleryCode'];
        $options = '';

        $q = "SELECT rackingCode, rackingName FROM racking WHERE galleryCode = '$galleryCode'";
        $r = mysqli_query($conn, $q);

        while ($row = mysqli_fetch_assoc($r)) {
            $options .= "<option value='{$row['rackingCode']}'>{$row['rackingName']}</option>";
        }
        echo $options;
        exit; 
    }