<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/showPostGeo.js', CClientScript::POS_BEGIN);
?>
<div class="row">
	<div class="span6">
	<?php
	foreach ($posts as $postnr => $postdata)
	{
	?>
	<article>
		<header>
			<h1><?php echo $postdata->title; ?></h1>
		</header>
		<p><?php echo $postdata->content; ?></p>
		<footer>
			<p>von <?php echo $postdata->_id; ?> in <?php echo $postdata->category; ?></p>
		</footer>
	</article>
	<?php
	}
	?>
	</div>
	<div class="span6">
		<div id="map" style="height:600px;">
		</div>
		<script type="text/javascript">
		var map;

		$(document).ready(function() {
			// load Posts as JSON-Object
			var posts = <?php if (isset($posts)) {echo json_encode($posts);} else { echo "";}?>;

			console.log(posts);
			map = new L.Map('map');
			tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm',attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'});

			var london = new L.LatLng(51.505, -0.09);
			// geographical point (longitude and latitude)
			map.setView(london, 13).addLayer(tile);

			// iterate through posts, and set Location-Markers
			for (var i = 0; i < posts.length; i++) {
				var latitude = posts[i].location[1];
				var longitude = posts[i].location[0];

				if (typeof(latitude) === 'number' && typeof(longitude) === 'number') {
					L.marker([latitude, longitude], {title : posts[i].title}).addTo(map);
				}
			}
		});
		</script>
	</div>
</div>