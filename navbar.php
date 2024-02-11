<?php
    session_start(); 
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }

    include 'header.php';
    $isAuthenticated = isset($_SESSION['access_token']);
?>

<style>
    .navbar-brand {
        font-size: 2rem;
        font-weight: bold;
    }

    .navbar {
        background-color: #78180c;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid w-75 d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-white" href="index.php">Web-AR</a>
        <?php if ($isAuthenticated): ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-end">
                    <li class="nav-item mt-2">
                        <span class="text-white">Welcome, <?php echo $_SESSION['profile']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>            
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>