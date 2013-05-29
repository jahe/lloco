<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/map.css", ''); ?>
<div id="mapView">
	<div id="map"></div>
</div>
<script type="text/javascript">
		var map;
		var markerGroup;

		function getPostsByViewport(e) {
			var bounds = map.getBounds();

				$.ajax({
					// pfad zur PHP Datei (ab HTML Datei)
					url: "<?php echo Yii::app()->createUrl('map/getposts'); ?>",
					// Daten, die an Server gesendet werden soll in JSON Notation
					data: {	nelng: bounds.getNorthEast().lng,
						nelat: bounds.getNorthEast().lat,
						swlng: bounds.getSouthWest().lng,
						swlat: bounds.getSouthWest().lat},
					datatype: "json",
					// Methode POST oder GET
					type: "GET",
					// Callback-Funktion, die nach der Antwort des Servers ausgefuehrt wird
					success: function(data) {
						// Antwort des Server ggf. verarbeiten
						markerGroup.clearLayers();

						//var response = $.parseJSON(data);
						response = data;
						var posts = response.posts;
						for (var i = 0; i < posts.length; i++) {
							var marker = L.marker([posts[i].location[1], posts[i].location[0]]);
							marker.post_id = posts[i]._id.$id;

							//marker.bindPopup("<i class='icon-spinner icon-spin'></i> Lädt...").openPopup();

							markerGroup.addLayer(marker);

							marker.on('click', function(e) {
								console.log(this);
								var that = this;
								$.get("<?php echo Yii::app()->createUrl('map/getpost'); ?>",
									{post_id: that.post_id},
									function(popupView) {
										that.bindPopup(popupView).openPopup();
									});
							});
						}
					}
				});
		}

		// --- Map-Anzeige ----
		$(document).ready(function() {
			map = new L.Map('map');

			markerGroup = L.layerGroup();
			//markerGroup = L.MarkerClusterGroup();
			markerGroup.addTo(map);

			map.on('viewreset', function(e) {
				getPostsByViewport(map);
			});
			map.on('dragend', function(e) {
				getPostsByViewport(map);
			});

			tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm',attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'});

			var london = new L.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
			// geographical point (longitude and latitude)
			map.setView(london, 13).addLayer(tile);

			// iterate through posts, and set Location-Markers
			/*
			for (var i = 0; i < posts.length; i++) {
				var latitude = posts[i].location[1];
				var longitude = posts[i].location[0];

				if (typeof(latitude) === 'number' && typeof(longitude) === 'number') {
					L.marker([latitude, longitude], {title : posts[i].title}).addTo(map);
				}
			}
			*/
		});
		</script>