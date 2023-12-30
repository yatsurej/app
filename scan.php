<?php
    $exhibitModel = isset($_GET['exhibitModel']) ? $_GET['exhibitModel'] : '';
?>

<script src="https://aframe.io/releases/1.3.0/aframe.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>

<body style="margin : 0px; overflow: hidden;">
    <a-scene embedded arjs>
        <a-marker preset="hiro">
        </a-marker>
        <a-entity camera></a-entity>
    </a-scene>
</body>