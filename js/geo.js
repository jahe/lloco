(function() {
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(setPosition, setError);
		}
		else {
			// not supported
		}
	}
	
	function setPosition(position) {
		/*var latitudeField = document.getElementById("Post_latitude");
		var longitudeField = document.getElementById("Post_longitude");
		latitudeField.value = position.coords.latitude;
		longitudeField.value = position.coords.longitude;*/

		//alert("Lat: " + position.coords.latitude + " Long: " + position.coords.longitude);
		//var map = L.map('map');
		var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
		//map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude));
		map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude), 8);
	}
	
	function setError(error) {
	}
	
	window.addEventListener("load", getLocation, false);
})();