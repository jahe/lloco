<?php  Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . "/css/map.css", ''); ?>
<div id="mapView">
	<div id="map"></div>
</div>
<script type="text/javascript">
		var map;
		var markerGroup;

		function getMarkerIcon(category_id) {
			var icon;

			console.log(category_id);

			switch (category_id) {
				case 'Meldung':
					return L.AwesomeMarkers.icon({
						icon: 'info',
						color: 'red',
						});
					break;
				case 'Essen':
					return L.AwesomeMarkers.icon({
						icon: 'food',
						color: 'cadetblue',
						});
					break;
				case 'Nachtleben':
					return L.AwesomeMarkers.icon({
						icon: 'glass',
						color: 'darkred',
						});
					break;
				case 'Kultur':
					return L.AwesomeMarkers.icon({
						icon: 'ticket',
						color: 'green',
						});
					break;
				case 'Einkaufen':
					return L.AwesomeMarkers.icon({
						icon: 'shopping-cart',
						color: 'blue',
						});
					break;
				case 'Sehenswert':
					return L.AwesomeMarkers.icon({
						icon: 'star',
						color: 'orange',
						});
					break;
				default:
					return L.AwesomeMarkers.icon({
						icon: 'question', 
						color: 'darkblue',
						});
					break;
			}
		}

		// Fragt Server anhand des aktuell in der Map sichtbaren Bereichs
		// (als "Rechteck" mit Lat u. Lng)
		// nach anzuzeigenden Posts ab.
		function getPostsByViewport(e) {
			var bounds = map.getBounds();

			$.ajax({
				url: "<?php echo Yii::app()->createUrl('map/getposts'); ?>",
				// Daten, die an Server gesendet werden soll in JSON Notation
				data: {	nelng: bounds.getNorthEast().lng,
					nelat: bounds.getNorthEast().lat,
					swlng: bounds.getSouthWest().lng,
					swlat: bounds.getSouthWest().lat},
				datatype: "json",
				// Methode POST oder GET
				type: "GET",
				// Callback-Funktion, die die Posts im JSON-Format aufbereitet und auf der Map darstellt
				success: function(data) {
					// Antwort des Server ggf. verarbeiten
					markerGroup.clearLayers();

					var posts = data.posts;
					for (var i = 0; i < posts.length; i++) {
						var markerIcon = getMarkerIcon(posts[i].category);

						var marker = L.marker([posts[i].location[1], posts[i].location[0]],
							{icon: markerIcon});

						marker.post_id = posts[i]._id.$id;

						markerGroup.addLayer(marker);

						marker.on('click', function(e) {
							console.log(this);
							var that = this;
							$.get("<?php echo Yii::app()->createUrl('map/getpost'); ?>",
								{post_id: that.post_id},
								function(popupView) {
									that.bindPopup(popupView).openPopup();
									that.unbindPopup();
								});
						});
					}
					markerGroup.addTo(map);
				}
			});
		}

		// --- Map-Anzeige ----
		$(document).ready(function() {
			map = new L.Map('map');

			// Geo Lokalisierung in der Map
			var geoControl = L.control.locate({
				position: 'topleft',  // set the location of the control
				drawCircle: true,  // controls whether a circle is drawn that shows the uncertainty about the location
				follow: false,  // follow the location if `watch` and `setView` are set to true in locateOptions
				circleStyle: {},  // change the style of the circle around the user's location
				markerStyle: {},
				metric: true,  // use metric or imperial units
				onLocationError: function(err) {alert(err.message)},  // define an error callback function
				title: "Ermittle meinen Standort.",  // title of the locat control
				popupText: ["<b>You</b> are within ", " from this point"],  // text to appear if user clicks on circle
				setView: true, // automatically sets the map view to the user's location
				locateOptions: {enableHighAccuracy: true}  // define location options e.g enableHighAccuracy: true
				});

			geoControl.addTo(map);

			// MarkerClusterGroup ist von LayerGroup abgeleitet!!!!

			//markerGroup = L.layerGroup();
			markerGroup = new L.MarkerClusterGroup();

			// Aktualisiere Map, bei Zoom-Änderung und Reset der Map
			map.on('viewreset', function(e) {
				getPostsByViewport(map);
			});

			// Aktualisiere Map, bei Verschiebung des Viewports
			map.on('dragend', function(e) {
				getPostsByViewport(map);
			});

			tile = new L.TileLayer('http://{s}.tile.cloudmade.com/8b600904281b42a6a54945da0a804c5d/997/256/{z}/{x}/{y}.png');
			//tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm'});
			// ,attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'

			var startPunkt = new L.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);
			// geographical point (longitude and latitude)
			map.setView(startPunkt, 13).addLayer(tile);

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