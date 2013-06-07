(function() {
    function setGeoFormValues(address, longitude, latitude) {
        // set hiddenfields with lat/lng Values
        // set address field with the google resolved address
    }
    /*
    GeoFilter = Object.extend({
        longitude : 0.0,
        latitude : 0.0,
        address : "",
        setLatLng : function (latitude, longitude) {
            // HIER NOCH IN FLOAT UMWANDELN!!!
            this.longitude = longitude;
            this.latitude = latitude;
            // HIER NOCH PER GOOGLE 
        }
    });
*/

    // Filter-Objekt-Beispiel: {cat: 'all', sort: 'close', latitude: 33.323, longitude: 34.3}
    function updatePosts(filter) {
        console.log(filter);

        $.ajax({
            //url: "<?php echo Yii::app()->createUrl('post/getposts'); ?>",
            url: "getposts",
            // Filterdaten übertragen
            data: filter,
            datatype: "html",
            // Methode POST oder GET
            type: "GET",
            // Callback-Funktion, die die Posts im JSON-Format aufbereitet und auf der Map darstellt
            success: function(data) {
                $('#posts').empty().append(data);
            }
        });
    }

    $(document).ready(function() {

        // ------ Formular Handler -------
        $("#filterForm").submit(function() {
            // HIER NOCH MAL DIE FORMULARDATEN VALIDIEREN!!!

            var filter = {
                cat: document.filterForm.cat.value,
                sort: document.filterForm.sort.value,
                latitude: document.filterForm.latitude.value,
                longitude: document.filterForm.longitude.value
            }
            updatePosts(filter);

            $('#filterMenu').collapse('hide');

            // "Normalen" Request unterbinden
            return false;
        });

        // ------ GeoLocation Finder -------
        $("#getGeoBtn").click(function() {
            $(this).button('loading');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    successCallback,
                    errorCallback_highAccuracy,
                    {maximumAge:60000, timeout:30000, enableHighAccuracy: false});
            }
            else {
                console.log("navigator objekt nicht vorhanden");
                $(this).button('reset');
            }
        });
    });

    function errorCallback_highAccuracy(error) {
        alert('Fehler bei Standortermittlung!' + error.message);
        /*
        if (error.code == error.TIMEOUT)
        {
            // Attempt to get GPS loc timed out after 5 seconds,
            // try low accuracy location
            $('body').append("attempting to get low accuracy location");
            navigator.geolocation.getCurrentPosition(
             successCallback,
             errorCallback_lowAccuracy,
             {maximumAge:600000, timeout:10000, enableHighAccuracy: false});
            return;
        }

        var msg = "<p>Can't get your location (high accuracy attempt). Error = ";
        if (error.code == 1)
            msg += "PERMISSION_DENIED";
        else if (error.code == 2)
            msg += "POSITION_UNAVAILABLE";
        msg += ", msg = "+error.message;

        $('body').append(msg);
        */
    }

    function errorCallback_lowAccuracy(position) {
        var msg = "<p>Can't get your location (low accuracy attempt). Error = ";
        if (error.code == 1)
            msg += "PERMISSION_DENIED";
        else if (error.code == 2)
            msg += "POSITION_UNAVAILABLE";
        else if (error.code == 3)
            msg += "TIMEOUT";
        msg += ", msg = "+error.message;
        
        $('body').append(msg);
    }

    function successCallback(position) {
        // hidden fields mit Werten füllen
        document.filterForm.latitude.value = position.coords.latitude;
        document.filterForm.longitude.value = position.coords.longitude;

        var geocoder = new google.maps.Geocoder();
        var latLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

        if (geocoder) {
            geocoder.geocode({ 'latLng': latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    console.log(results[0].formatted_address);
                    $('#filterAdress').val(results[0].formatted_address);
                    //$('body').append("<p>Your adress is: " + results[0].formatted_address);
                }
            else {
                console.log("Geocoding failed: " + status);
            }
            });
        }
        $('#getGeoBtn').button('reset');
    }
})();