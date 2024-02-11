<?php
    $pageTitle = "Profile Page";
    require '../db_connect.php';
    include '../header.php';
    include 'navbar.php';

    if (isset($_SESSION['username'])) {
        $username    = $_SESSION['username'];
        $staffQuery  = "SELECT * FROM user WHERE username = '$username'";
        $staffResult = mysqli_query($conn, $staffQuery);

        while($staffRow = mysqli_fetch_assoc($staffResult)){
            $ID             = $staffRow['userID'];
            $firstName      = $staffRow['firstName'];
            $lastName       = $staffRow['lastName'];
            $contactNumber  = $staffRow['contactNumber'];
            $username       = $staffRow['username'];
            $password       = $staffRow['password'];
        }
    } else {
        header('Location: index.php');
        exit();
    }

?>


<div class="container w-75">
    <h1 class="text-start fw-bold mt-3">Your Profile</h1>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    <div class="row justify-content-center">
        <input type="hidden" name="staffID" value="<?php echo $ID; ?>">
        <div class="form-group">
            <label class= "fw-bold" for="name">Name</label>
            <input class="form-control" type="text" name="name" id="name" value="<?php echo $firstName . ' ' . $lastName;?>" readonly>
        </div>
        <div class="form-group">
            <label class= "fw-bold" for="contactNumber">Contact Number</label>
            <input class="form-control" type="text" name="contactNumber" id="contactNumber" value="<?php echo $contactNumber;?>" readonly>
        </div>
        <div class="form-group">
            <label class= "fw-bold" for="username">Username</label>
            <input class="form-control" type="text" name="username" id="username" value="<?php echo $username;?>" readonly>
        </div>
        <div class="form-group">
            <label class= "fw-bold" for="password">Password</label>
            <div class="input-group">
                <input class="form-control" type="password" name="password" id="password" value="<?php echo $password;?>" readonly>
                <div class="input-group-append">
                    <span class="input-group-text" id="toggle-password">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
        </div>
        <hr style="height:1px;border-width:0;color:gray;background-color:gray">
        <div class="text-start">
            <button class="btn btn-dark" name="editProfile" data-bs-toggle="modal" data-bs-target="#editProfileModal<?php echo $ID; ?>">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span class="ms-2">Edit Profile</span>
                </div>
            </button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProfileModal<?php echo $ID; ?>" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="functions.php" method="post">
                    <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstName; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastName; ?>">
                    </div>
                    <div class="mb-3">
                        <label for=" contactNumber" class="form-label">Contact Number</label>
                        <input type="number" class="form-control" id=" contactNumber" name=" contactNumber" value="<?php echo $contactNumber; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="password" id="password-edit" value="<?php echo $password;?>" required>
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-password-edit">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="editProfile" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
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

        // Eye button in the edit modal
        const passwordInputEdit = document.getElementById('password-edit');
        const togglePasswordButtonEdit = document.getElementById('toggle-password-edit');

        togglePasswordButtonEdit.addEventListener('click', function () {
            const type = passwordInputEdit.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputEdit.setAttribute('type', type);
            togglePasswordButtonEdit.innerHTML = type === 'password' ? '<i class="fa fa-eye" aria-hidden="true"></i>' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        });
    });
</script>
