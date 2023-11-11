<?php
$menuItems = array(
    'Racking' => 'racking.php',
    'Gallery' => 'gallery.php',
    'Establishment' => 'establishment.php',
);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'racking.php';
?>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Inventory</h1>

    <ul class="nav nav-tabs">
        <?php
        echo '<a class="nav-link" href="exhibits.php">&lt;</a>';
        foreach ($menuItems as $menuItem => $page) {
            $isActive = ($page === $currentPage) ? 'active' : '';
            echo '<li class="nav-item">';
            echo '<a class="nav-link ' . $isActive . '" href="' . $page . '?page=' . basename($page, '.php') . '">' . $menuItem . '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>
