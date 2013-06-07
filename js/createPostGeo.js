/*
 * Standortermittlung für das Postformular 'createPost.php'
*/

(function() {
  $(document).ready(function() {
    $('#inputFotos').change(function(event) {
      dateiausgabe(event);
    });

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        successCallback,
        errorCallback,
        {maximumAge:600000, timeout:60000, enableHighAccuracy: true});
    }
    else {
      $('#locationstatus').replaceWith(
        '<div class="alert alert-error">' +
        '<h4>Fehler bei Standortermittlung!</h4>' +
        'Ihr Browser untestützt die Standortermittlung leider nicht. Bitte bringen Sie Ihren Browser auf die neuste Version und versuchen Sie es erneut' +
        '</div>');
    }
  });

  function dateiausgabe(event) {
    var dateien = event.target.files;

    for (var i = 0, datei; datei = dateien[i]; i++) {
      var inhalte = new FileReader();

      inhalte.onload = (function(datei) {
        return function(e) {
          var element = document.createElement("LI");
          //var info = document.createTextNode(datei.name + " (" + datei.type + "), " + datei.size + " Bytes");
          var bild = document.createElement("IMG");
          bild.setAttribute("src", e.target.result);
          bild.className = "thumbnail";

          //element.appendChild(info);
          //element.appendChild(document.createElement("BR"));
          element.appendChild(bild);

          document.getElementById("fotoliste").appendChild(element);
        };
      })(datei);
      inhalte.readAsDataURL(datei);
    }
  }

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
    tile = new L.TileLayer('http://{s}.tile.cloudmade.com/8b600904281b42a6a54945da0a804c5d/997/256/{z}/{x}/{y}.png');

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