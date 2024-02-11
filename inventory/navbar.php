<?php
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }

    if (!isset($_SESSION)) {
        session_start();
    }
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
        <a class="navbar-brand" href="index.php">Web-AR</a>
        <?php if (isset($_SESSION['user_authenticated'])): ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-end">
                    <?php if ($_SESSION['user_role'] == 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback.php">Feedback</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="staff.php">Staff</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    <?php elseif ($_SESSION['user_role'] == 'Staff'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback.php">Feedback</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                    <?php endif; ?>
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