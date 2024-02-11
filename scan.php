<?php
    $exhibitModel = isset($_GET['exhibitModel']) ? $_GET['exhibitModel'] : '';
?>

<script src="https://aframe.io/releases/1.3.0/aframe.min.js"></script>
<script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
<script src="https://raw.githack.com/fcor/arjs-gestures/master/dist/gestures.js"></script>

<body style="margin : 0px; overflow: hidden;">
    <a-scene arjs embedded gesture-detector>
        <a-marker preset="hiro">
            <a-entity position="0. 0 0"
                gltf-model="<?php echo $exhibitModel;?>"
                scale="1 1 1"
                gesture-handler="minScale: 0.25; maxScale: 10"
            ></a-entity>
        </a-marker>
        <a-entity camera></a-entity>
    </a-scene>
</body>