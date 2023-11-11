<?php
$menuItems = array(
    'Dashboard' => 'dashboard.php',
    'Transaction' => 'transaction.php',
    'History' => 'history.php',
    'Exhibits' => 'exhibits.php',
    'Location' => 'racking.php'
);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 'exhibits.php';
?>

<div class="container w-50 my-3">
    <h1 class="text-start mt-4">Inventory</h1>

    <ul class="nav nav-tabs">
        <?php
        foreach ($menuItems as $menuItem => $page) {
            $isActive = ($page === $currentPage) ? 'active' : '';
            echo '<li class="nav-item">';
            echo '<a class="nav-link ' . $isActive . '" href="' . $page . '?page=' . basename($page, '.php') . '">' . $menuItem . '</a>';
            echo '</li>';
        }
        ?>
    </ul>
</div>
