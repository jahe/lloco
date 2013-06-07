<!DOCTYPE html>
<html lang="de">
    <head>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- leaflet.js -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/core/leaflet.css">
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/core/leaflet.ie.css">
        <![endif]-->

        <!-- Leaflet-Plugin: Markercluster -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/Leaflet.markercluster/MarkerCluster.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/Leaflet.markercluster/MarkerCluster.Default.css">
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/Leaflet.markercluster/MarkerCluster.Default.ie.css">
        <![endif]-->

        <!-- Leaflet-Plugin: Awesome-Markers -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/Leaflet.awesome-markers/leaflet.awesome-markers.css">

        <!-- Leaflet-Plugin: Awesome-Markers -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/leaflet-locatecontrol/L.Control.Locate.css">
        <!--[if lte IE 8]>
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/Leaflet/plugins/leaflet-locatecontrol/L.Control.Locate.ie.css">
        <![endif]-->

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-tag.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/lib/font-awesome/css/font-awesome.min.css">

        <!-- Mein Layout-CSS -->
        <?php //Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/layout.css", ''); ?>
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.css">

		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body style="background-image: url(<?php echo Yii::app()->request->baseUrl; ?>/img/background.png); background-repeat: repeat;">
        <!-- Navigationsleiste -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <!-- Collapse-Button -->
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="<?php echo Yii::app()->createUrl('map/explore'); ?>">lloco</a>
                    <ul class="nav">
                        <li><a href="<?php echo Yii::app()->createUrl('map/explore'); ?>"><i class="icon-map-marker icon-white"></i>&nbsp;&nbsp;Map</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('post/overview'); ?>"><i class="icon-th icon-white"></i>&nbsp;&nbsp;Überblick</a></li>
                    </ul>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
	                    </ul>
	                    <ul class="nav pull-right">
	                    	<?php
	                    	if (Yii::app()->user->isGuest)
	                    		$this->widget('LLoginForm');
	                    	else
	                    		$this->widget('LUserMenu');
	                    	?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container" id="content">
        <?php echo $content; ?>
        </div>
        <!--
        <footer class="container">
            <p>
                <span class="label label-important"><i class="icon-map-marker icon-white"></i> <strong><span id="posts"> </span></strong> Posts
            </p>
        </footer>
        -->

        <?php
        // ---- JavaScript includes ----
        //Yii::app()->clientScript->registerScriptFile('http://code.jquery.com/jquery.js', CClientScript::POS_BEGIN);
        //Yii::app()->clientScript->registerScriptFile('http://cdn.leafletjs.com/leaflet-0.5/leaflet.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-tag.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/lib/Leaflet/core/leaflet.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/lib/Leaflet/plugins/Leaflet.markercluster/leaflet.markercluster.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/lib/Leaflet/plugins/Leaflet.awesome-markers/leaflet.awesome-markers.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/lib/Leaflet/plugins/leaflet-locatecontrol/L.Control.Locate.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.js', CClientScript::POS_BEGIN);

        ?>
        
        <!--<script src="http://localhost:8000/socket.io/socket.io.js"></script>-->
        <!--<script>
            var map;
            $(document).ready(function() {
                console.log(map);
            });
            window.onload = function () {
                map = new L.Map('map');

                tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm',attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'});

                var london = new L.LatLng(51.505, -0.09);
                // geographical point (longitude and latitude)
                map.setView(london, 13).addLayer(tile);
                //map.setView(new L.LatLng(40.737, -73.923), 8);
                /*
                var socket = io.connect("http://localhost:8000");

                var postsSpan = document.getElementById("posts");

                socket.on('status', function (data) {
                var status = JSON.parse(data);
                postsSpan.firstChild.nodeValue = status.posts;
                });
                */
            }
        </script>-->
    </body>
</html>