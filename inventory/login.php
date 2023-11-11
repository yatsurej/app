<?php
    $pageTitle = "Login Page";
    require '../db_connect.php';
    include '../header.php';
    include 'navbar.php';
?>

<div class="container">
    <h1 class="text-center py-4 my-1">Login</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="functions.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Enter Password" required>
                </div>
                <br>
                <button class="btn btn-dark" name="login">Login</button><br><br>
            </form>
        </div>
    </div>
</div>