window.gMap = function () {
	function loadMap() {
		// var centerMap = new google.maps.LatLng(lat, long);
		var myOptions = {
			zoom: gmap_config.zoomLevel,
			// center: centerMap,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: gmap_config.mapStyles
		};
		var map = new google.maps.Map(document.getElementById(gmap_config.mapElement), myOptions);
		setMarkers(map, gmap_config.marker_config);
		var infowindow = new google.maps.InfoWindow({
			content: "loading..."
		});
		var bikeLayer = new google.maps.BicyclingLayer();
		bikeLayer.setMap(map);
	}
	// end loadmap

	function setMarkers(map, marker_config) {
		// Add markers to the map
		var map_markers = [];
		var curMarker='';
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0; i < marker_config.length; i++) {
			var sites = marker_config[i];
			var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
			var marker = new google.maps.Marker({
				position: siteLatLng,
				map: map,
				animation: google.maps.Animation.DROP,
				icon: sites[3],
				title: sites[0],
				html: sites[4].replace(/\\/g,"")
			});
			map_markers.push(marker);
			var contentString = "Some content";
			infowindow = new google.maps.InfoWindow({
				content: "loading..."
			});
			google.maps.event.addListener(marker, "click", function () {
				infowindow.setContent(this.html);
				infowindow.open(map, this);
			});
			bounds.extend(siteLatLng);

			if (map_markers.length==1) {
				zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
					if (map.getZoom()) {
						map.setZoom(gmap_config.zoomLevel);
					}
				});
				setTimeout(function() {google.maps.event.removeListener(zoomChangeBoundsListener);}, 2000);
			}
			else {
				map.fitBounds(bounds);
			}
		}

		if (curMarker != '') {
			infowindow = new google.maps.InfoWindow({
				content: curMarker.html
			});
			//infowindow.setContent(marker.html);
			infowindow.open(map, curMarker);
			map.panTo(curMarker.getPosition());
		}
		map.setCenter(marker.getPosition());
	}
	// end setMarkers

	function myclick(i) {
		google.maps.event.trigger(map_markers[i], "click");
		map.setCenter(map_markers[i].getPosition());
		map.setZoom(10);
	}

	// init
	return {
		init: function () {
			loadMap();
		},
		mapOpen: function (i) {
			myclick(i);
		},
	};
}();
