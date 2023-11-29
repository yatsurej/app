<?php
    $pageTitle = "Web-AR";
    include 'header.php';
    include 'navbar.php';
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['selectedEstablishment'] = $_POST['establishment'];
        header("Location: view-exhibit.php");
        exit();
    }
?>

<div class="container w-50 mt-4 text-center">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3 class="mb-3 fst-italic">Select an Establishment</h3>
        <?php
        $establishmentQuery = "SELECT * FROM establishment WHERE establishmentName <> 'Stockroom'";
        $establishmentResult = mysqli_query($conn, $establishmentQuery);

        while ($establishmentRow = mysqli_fetch_assoc($establishmentResult)) {
            $establishmentCode = $establishmentRow['establishmentCode'];
            $establishmentName = $establishmentRow['establishmentName'];
            ?>
            <div class="mb-4">
                <button type="submit" class="btn btn-link" name="establishment" value="<?php echo $establishmentCode; ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $establishmentName; ?></h5>
                        </div>
                    </div>
                </button>
            </div>
            <?php
        }
        ?>
    </form>
</div>
