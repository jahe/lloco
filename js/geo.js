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
		var latitudeField = document.getElementById("Post_latitude");
		var longitudeField = document.getElementById("Post_longitude");
		latitudeField.value = position.coords.latitude;
		longitudeField.value = position.coords.longitude;
	}
	
	function setError(error) {
	}
	
	window.addEventListener("load", getLocation, false);
})();