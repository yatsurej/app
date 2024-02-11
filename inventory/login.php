<?php
    session_start();

    if (isset($_SESSION['user_authenticated'])) {
        header('Location: index.php');
        exit();
    }

    $pageTitle = "Login Page";
    require '../db_connect.php';
    include '../header.php';
    include 'navbar.php';
    
?>


<div class="container w-75">
    <h1 class="text-start fw-bold mt-3">Log in</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="row justify-content-center">
        <form action="functions.php" method="post" autocomplete="off">
            <div class="form-group">
                <label class= "fw-bold" for="username">Username</label>
                <input class="form-control" type="text" name="username" id="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label class= "fw-bold" for="password">Password</label>
                <div class="input-group">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Enter password" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-password">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center">
                <button class="btn btn-dark mb-3" name="login">Log in</button>
            </div>
            <hr style="height:1px;border-width:0;color:gray;background-color:gray">
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('toggle-password');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePasswordButton.innerHTML = type === 'password' ? '<i class="fa fa-eye" aria-hidden="true"></i>' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        });
    });
</script>
