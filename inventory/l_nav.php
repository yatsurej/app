<?php
    if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
        header("Location: index.php");
        exit();
    }
?>
<style>
    .nav-link.inactive {
        color: darkgray;
    }
    .arrow{
        color: darkgray;
    }
</style>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Inventory</h1>
    <ul class="nav nav-tabs">
        <a class="nav-link arrow" href="<?php echo $_SESSION['last_active_page']; ?>">&lt;</a>  
        <li class="nav-item">        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'racking.php') ? 'active' : 'inactive'; ?>" href="racking.php">Racking</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'Gallery.php') ? 'active' : 'inactive'; ?>" href="Gallery.php">Gallery</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'establishment.php') ? 'active' : 'inactive'; ?>" href="establishment.php">Establishment</a>
        </li>
    </ul>
</div>
