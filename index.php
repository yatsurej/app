<?php
    $pageTitle = "Web-AR";
    include 'header.php';
    include 'navbar.php';
    session_start();
    
    require_once('vendor/autoload.php');
    
    $clientID = "47852619874-gd8grjpupi6v2824afhlvm45mtbu8kvp.apps.googleusercontent.com";
    $secret = "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";
    
    // Google API Client
    $gclient = new Google_Client();
    
    $gclient->setClientId($clientID);
    $gclient->setClientSecret($secret);
    $gclient->setRedirectUri('http://localhost/capstone/index.php');
    
    
    $gclient->addScope('email');
    $gclient->addScope('profile');
    
    if(isset($_GET['code'])){
        $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
    
        if(!isset($token['error'])){
            $gclient->setAccessToken($token['access_token']);
    
            $_SESSION['access_token'] = $token['access_token'];
    
            $gservice = new Google_Service_Oauth2($gclient);
    
            $udata = $gservice->userinfo->get();
            foreach($udata as $k => $v){
                $_SESSION['login_'.$k] = $v;
            }
            $_SESSION['ucode'] = $_GET['code'];
            $_SESSION['user_email'] = $udata->email;
            header('location: feedback.php');
            exit;
        }
    }
?>
<style>
    model-viewer{
        width: 100%;
        height: 100%;
        margin: 0px;
    }
    .exhibit-box {
        cursor: pointer;
        width: 100%;
        max-width: 300px;
    }
    
    #exhibitModal .modal-body img {
        max-width: 100%; 
        max-height: 300px; 
        width: auto; 
        height: auto; 
    }
</style>

<!-- buttons -->
<div class="container mt-1 text-center">
    <a href="feedback.php" type="button" class="btn btn-dark">
        Send Feedback 
    </a>
    <a href="<?= $gclient->createAuthUrl() ?>" class="btn btn btn-secondary">Login with Google</a>
</div>

<!-- exhibit boxes -->
<div class="container w-50 mt-5">
    <div class="row">
        <?php
        $conn = new mysqli("localhost", "root", "", "webar");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM exhibits";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4 exhibit-box" data-toggle="modal" data-target="#exhibitModal" data-name="' . $row["name"] . '" data-description="' . $row["information"] . '" data-model="' . $row["model"] . '">';
                echo '<div class="card">';
                echo '<div class="card-body text-center">';
                echo '<h5 class="card-title">' . $row["name"] . '</h5>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "0 results found";
        }
        $conn->close();
        ?>
    </div>
</div>

<!-- Exhibit Modal -->
<div class="modal fade" id="exhibitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exhibit Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <model-viewer 
                            src="https://yatsurej.github.io/3d-models/ship_in_a_bottle/scene.gltf" 
                            ar 
                            camera-controls 
                            touch-action="pan-y">
                        </model-viewer>
                    </div>
                    <div class="col-md-8 text-right">
                        <h2 id="modal-exhibit-name"></h2>
                        <p id="modal-exhibit-description"></p>
                        <div id="modal-3d-model"></div>
                            <button class="btn btn-primary">View 3D Model</button>
                            <button class="btn btn-secondary ml-2">Scan</button>
                            <div class="form-group">
                    <label for="rating">Rate this exhibit:</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<model-viewer 
    src="https://yatsurej.github.io/3d-models/ship_in_a_bottle/scene.gltf" 
    ar 
    camera-controls 
    touch-action="pan-y">
</model-viewer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to handle modal content -->
<script>
    $('.exhibit-box').click(function() {
        var name = $(this).data('name');
        var description = $(this).data('description');
        var modelUrl = $(this).data('model');
        var modal = $('#exhibitModal');
        modal.find('#modal-exhibit-name').text(name);
        modal.find('#modal-exhibit-description').text(description);
        });
</script>

<script>
    $('.exhibit-box').click(function() {
    var name = $(this).data('name');
    var description = $(this).data('description');
    var exhibitId = $(this).data('id');
    var modal = $('#exhibitModal');

    modal.find('#modal-exhibit-name').text(name);
    modal.find('#modal-exhibit-description').text(description);

    // Star rating interaction
    $('.star').click(function() {
        var rating = $(this).data('rating');
       
        $('.star').removeClass('selected');
        $(this).addClass('selected');
        
        // Send rating to the server using AJAX
        $.ajax({
            type: 'POST',
            url: 'submit_rating.php', // PHP script to handle rating submission
            data: { exhibitId: exhibitId, rating: rating },
            success: function(response) {
               
                console.log('Rating submitted successfully!');
            },
            error: function(xhr, status, error) {

                console.error('Error submitting rating: ' + error);
            }
        });
    });
});
</script>