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
		var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
		//map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude));
		map.setView(new L.LatLng(position.coords.latitude, position.coords.longitude), 13);
		document.createPost.latitude.value = position.coords.latitude;
		document.createPost.longitude.value = position.coords.longitude;
	}
	
	function setError(error) {
	}
	
	window.addEventListener("load", getLocation, false);
})();