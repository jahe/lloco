<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/createPostGeo.js', CClientScript::POS_BEGIN);
?>
<form class="form-horizontal" method="post" name="createPost" action="<?php echo $actionPath ?>">
  <div class="control-group">
    <label class="control-label" for="inputTitle">Titel</label>
    <div class="controls">
      <input type="text" id="inputTitle" placeholder="Titel..." name="title">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputNachricht">Nachricht</label>
    <div class="controls">
      <textarea rows="3" id="inputNachricht" placeholder="Nachricht..." name="content"></textarea>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputCategory">Kategorie</label>
    <div class="controls">
      <select name="category" id="inputCategory">
      <?php
      foreach ($categories as $nr => $catdata)
      {
        echo "<option value=\"$catdata->title\">$catdata->title</option>";
      }
      ?>
      </select>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputLocation">Standort</label>
    <div class="controls">
      <div id="map" style="height:300px;"></div>
      <script type="text/javascript">
        var map;

        $(document).ready(function() {
          map = new L.Map('map');
          tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm',attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'});

          var london = new L.LatLng(51.505, -0.09);
          // geographical point (longitude and latitude)
          map.setView(london, 13).addLayer(tile);
        });
      </script>
      <input type="hidden" name="latitude" value="">
      <input type="hidden" name="longitude" value="">
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Posten</button>
    </div>
  </div>
</form>
