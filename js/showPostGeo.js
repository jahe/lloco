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
		map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude), 13);
	}
	
	function setError(error) {
	}
	
	window.addEventListener("load", getLocation, false);
})();