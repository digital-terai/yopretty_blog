var gmarkers = [];
var map;
window.gMap = function () {
	function loadMap() {
	    var centerMap = new google.maps.LatLng(lat, long);
	    var myOptions = {
	        zoom: zoomLevel,
	        center: centerMap,
	        mapTypeId: google.maps.MapTypeId.ROADMAP,
	        styles: mapStyles
	    }
	    map = new google.maps.Map(document.getElementById("map"), myOptions);
	    setMarkers(map, sites);
	    infowindow = new google.maps.InfoWindow({
	        content: "loading..."
	    });
	    var bikeLayer = new google.maps.BicyclingLayer();
		bikeLayer.setMap(map);
	}
	// end loadmap

    function setMarkers(map, markers) {
		// Add markers to the map
		var curMarker='';
		var bounds = new google.maps.LatLngBounds();
      	for (var i = 0; i < markers.length; i++) {
	        var sites = markers[i];
	        var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
	        var marker = new google.maps.Marker({
	            position: siteLatLng,
	            map: map,
	            animation: google.maps.Animation.DROP,
				icon: mapIcons,
	            title: sites[0],
	            zIndex: (sites[5]==id_page)?1000:sites[3],
	            html: sites[4].replace(/\\/g,"")
	        });
	        gmarkers.push(marker)
			if(sites[5]==id_page){
			   	curMarker=marker;
			}
			var contentString = "Some content";
				infowindow = new google.maps.InfoWindow({
				content: "loading..."
			});
	        google.maps.event.addListener(marker, "click", function () {
					infowindow.setContent(this.html);
					infowindow.open(map, this);
			});
			bounds.extend(siteLatLng);
			map.fitBounds(bounds);
	        if(markers.length==1){
				zoomChangeBoundsListener = google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
					if (map.getZoom()) {
						map.setZoom(zoomLevel);
					}
				});
				setTimeout(function() {google.maps.event.removeListener(zoomChangeBoundsListener)}, 2000);
			}
	 	}

		if(curMarker!=''){
			var infowindow = new google.maps.InfoWindow({
				 content: curMarker.html
			});

			//infowindow.setContent(marker.html);
			infowindow.open(map, curMarker);
			map.panTo(curMarker.getPosition());
		}
		map.setCenter(marker.getPosition())
	}
    // end setMarkers

    function myclick(i) {
 	   google.maps.event.trigger(gmarkers[i], "click");
 	   map.setCenter(gmarkers[i].getPosition())
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

function myclick(i) {
	google.maps.event.trigger(gmarkers[i], "click");
	map.setCenter(gmarkers[i].getPosition())
	map.setZoom(10);
}
