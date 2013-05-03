/*
 * Standortermittlung für das Postformular 'createPost.php'
*/

(function() {
  $(document).ready(function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        successCallback,
        errorCallback,
        {maximumAge:600000, timeout:5000, enableHighAccuracy: true});
    }
    else {
      $('#locationstatus').replaceWith(
        '<div class="alert alert-error">' +
        '<h4>Fehler bei Standortermittlung!</h4>' +
        'Ihr Browser untestützt die Standortermittlung leider nicht. Bitte bringen Sie Ihren Browser auf die neuste Version und versuchen Sie es erneut' +
        '</div>');
    }
  });

  function successCallback(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var accuracy = position.coords.accuracy;

    // hidden fields mit Werten füllen
    document.createPost.latitude.value = position.coords.latitude;
    document.createPost.longitude.value = position.coords.longitude;

    // Status-Info entfernen
    $('#locationstatus').remove();

    // "Posten"-Button aktivieren
    $('#submitpost').toggleClass('disabled').removeAttr("disabled");

    initMap(position);
  }

  function errorCallback(error) {
    switch (error.code) {
      case error.PERMISSION_DENIED:
        $('#locationstatus').replaceWith(
          '<div class="alert alert-error">' +
          '<h4>Fehler bei Standortermittlung!</h4>' +
          'Die Standortermittlung wurde nicht erlaubt. ' +
          '</div>');
        break;
      case error.POSITION_UNAVAILABLE:
        $('#locationstatus').replaceWith(
        '<div class="alert alert-error">' +
        '<h4>Fehler bei Standortermittlung!</h4>' +
        'Es liegen leider keine Positionsdaten vor.' +
        '<button type="button" class="btn" data-loading-text="ermittelt...">erneut versuchen</button>' +
        '</div>');
        break;
      case error.TIMEOUT:
        $('#locationstatus').replaceWith(
        '<div class="alert alert-error">' +
        '<h4>Fehler bei Standortermittlung!</h4>' +
        'Die Ermittlung dauerte zu lang.' +
        '<button type="button" class="btn" data-loading-text="ermittelt...">erneut versuchen</button>' +
        '</div>');
        break;
      case error.UNKNOWN_ERROR:
        $('#locationstatus').replaceWith(
        '<div class="alert alert-error">' +
        '<h4>Unbekannter Fehler bei Standortermittlung!</h4>' +
        '<button type="button" class="btn" data-loading-text="ermittelt...">erneut versuchen</button>' +
        '</div>');
        break;
    }
  }

  function initMap(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    var accuracy = position.coords.accuracy;

    // MapDiv erzeugen
    var mapDiv = document.createElement('div');
    mapDiv.setAttribute('id', 'map');
    mapDiv.setAttribute('style', 'height:300px;');

    $('#locationwrapper').append(mapDiv);

    var map = new L.Map('map');
    tile = new L.TileLayer('http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png', {subdomains: '1234',type: 'osm',attribution: 'Map data ' + L.TileLayer.OSM_ATTR + ', ' + 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />'});

    // focus on location
    map.setView([latitude, longitude], 17).addLayer(tile);

    // radius für die Genauigkeit setzen
    var circle = L.circle([latitude, longitude], accuracy, {
      color: 'red',
      fillColor: '#f03',
      fillOpacity: 0.5
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);
  }
})();