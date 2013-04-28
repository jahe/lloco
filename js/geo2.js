if (!lloco)
	var lloco = {};

(function () {
	function GeoProvider() {
		var callbacks = new Array();
		
		function onPosition(position) {
			for (var i = 0; i < callbacks.length; i++) {
				callbacks[i](position);
			}
		}
		
		function onError(error) {
		}
		
		this.registerCallback = function (callback) {
			callbacks[callbacks.length] = callback;
		};
		
		this.getLocation = function () {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(onPosition, onError);
			}
			else {
				// not supported
			}
		};
	}
	lloco.GeoProvider = GeoProvider;
})();