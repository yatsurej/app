<?php
    session_start();

    $pageTitle = "Feedback Form";
    include 'header.php';
    include 'navbar.php';
    include 'db_connect.php';

    if (isset($_SESSION['user_email'])) {
        $userEmail = $_SESSION['user_email'];
    } else {
        $userEmail = "Not logged in";
    }
?>

<div class="w-50 m-auto">
    <h1 class="text-start py-4 my-1">Feedback</h1>
    <form action="functions.php" method="post" autocomplete="off">
        <input type="hidden" name="userEmail" value="<?php echo $userEmail; ?>">
        <div class="form-group">
            <textarea class="form-control w-100" rows="10" name="userFeedback" id="userFeedback" required></textarea>
        </div>
        <button class="btn btn-secondary mt-2" type="submit" name="sendFeedback">Send</button>
    </form>
</div>
