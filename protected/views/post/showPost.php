<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/geo2.js');
?>

<?php
	Yii::app()->clientScript->registerScript('geoAjax',
		"var geo = new lloco.GeoProvider();"
		. "window.addEventListener('load', geo.getLocation, false);"
		. "geo.registerCallback(function (position) {"
		. CHtml::ajax(array('url' => CController::createUrl('post/show'),
							'type' => 'POST',
							'data' => 'js:{longitude: position.coords.longitude, latitude: position.coords.latitude}',
							'update' => '#data'))
		. "});"
	);
?>

<div class="row">
	<div class="span6" id="data">
	Lade Posts...
	</div>
	<div class="span6">
		<div id="map" style="height:600px;">
		</div>
	</div>
</div>