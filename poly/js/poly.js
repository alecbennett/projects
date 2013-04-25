


// Global variables
	var map;
	var layer;
	var rectangle;
	var polygon;
	var polyline;
	var point_list = new google.maps.MVCArray();
	var marker_list = [];
	var poly_listener;
	var pointLayer = "";

      /**
       * Called on the initial page load.
       */
	function init() {
		map = new google.maps.Map(document.getElementById('map_canvas'), {
			'zoom': 4,
			'center': new google.maps.LatLng(63.5, -147),
			disableDefaultUI: true,
			navigationControl: true,
			navigationControlOptions: {
				position: google.maps.ControlPosition.RIGHT_TOP
			},
			scaleControl: true,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
			},
			'mapTypeId': google.maps.MapTypeId.ROADMAP
		});
		updateLayer();
      }
      function updateLayer(){
		var tilepath = "http://tiles.snap.uaf.edu/tilecache/tilecache.cgi/2.11.0/" + layer;
		var defmap = new google.maps.ImageMapType({
			getTileUrl: function(tile, zoom) {
				return tilepath + "/" + zoom + "/" + tile.x + "/" + tile.y + ".png";
			},
			tileSize: new google.maps.Size(256, 256),
			opacity: 0.75
		});

		map.overlayMapTypes.push(null); // create empty overlay entry
		map.overlayMapTypes.setAt("0", defmap);
		var gnames = new google.maps.ImageMapType({
			getTileUrl: function(a, z) {
			var tiles = 1 << z, X = (a.x % tiles);
			if(X < 0) { X += tiles; }
			return "http://mt0.google.com/vt/v=apt.116&hl=en-US&x=" +
			X + "&y=" + a.y + "&z=" + z + "&s=G&lyrs=h";
			},
			tileSize: new google.maps.Size(256, 256),
			isPng: false,
			maxZoom: 20,
			name: "lyrs=h",
			alt: "Hybrid labels"
			});
		map.overlayMapTypes.push(null); // create empty overlay entry
		map.overlayMapTypes.setAt("1",gnames );
	}
	/*
 	* Functions relating to Polygon manipulation
 	*/
	function hidePoly(){
		if (poly_listener){
	                google.maps.event.removeListener(poly_listener);
		}
		if (polyline){
			polyline.setMap(null);
		}
		if (polygon){
			polygon.setMap(null);
		}
		if (marker_list){
			for (var i = 0; i < marker_list.length; i++){
				this.marker_list[i].setMap(null);
			}
		}
		document.getElementById(pointLayer).innerHTML = "";
	}

	function drawPolygon(){

		if (rectangle){
			hideRectangle();
		}

		if (poly_listener){
	                google.maps.event.removeListener(poly_listener);
		}

		poly_listener = google.maps.event.addListener(map, 'click', function(event) {
			placePolyMarker(event.latLng);
		});
		point_list = [];
		if (marker_list){
			for (var i = 0; i < marker_list.length; i++){
				this.marker_list[i].setMap(null);
			}	

		}
		marker_list = [];
		if (polyline){
			polyline.setMap(null);
		}
		polyline = new google.maps.Polyline({
		  map: map,
		  strokeColor: "#333333",
		  strokeWeight: "4"
		});
		if (polygon){
			polygon.setMap(null);
		}
		polygon = new google.maps.Polygon({
          		map: map,
	  		fillColor: "#333333",
	  		fillOpacity: "0.2",
	  		strokeColor: "#333333",
	  		strokeWeight: "1"
		});
		
	}
	function placePolyMarker(location) {
		var marker = new google.maps.Marker({
			position: location, 
		  	draggable: true,
			map: map,
			title: "P" + marker_list.length
		});
		if (marker_list.length < 1){
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/red-dot.png");
		} else {
			marker.setIcon("http://maps.google.com/mapfiles/ms/icons/red.png");
		}
		marker_list.push(marker);
		point_list.push(location);
		if (marker_list.length == "1"){
			google.maps.event.addListener(marker, 'click', function (event) {
				closePoly();
			});
		}
		google.maps.event.addListener(marker, 'drag', function (event) {
				dragPolyMarker(marker);
		});
		polyline.setPath(point_list);
		updatePointList();
	}
	function dragPolyMarker(m){
		var pIndex = m.getTitle().substring(1);
		point_list[pIndex] = m.getPosition();
		polygon.setPaths(point_list);
		updatePointList();
	}
	function closePoly(){
		polygon.setPaths(point_list);
		polygon.setMap(map);
		polyline.setMap(null);
		google.maps.event.removeListener(poly_listener);
		for (var i = 0; i < marker_list.length; i++){
			marker_list[i].setMap(null);
		}
		google.maps.event.addListener(polygon,"click",function(){
			alert("You clicked a Polygon");
		}); 
		google.maps.event.addListener(polygon,"mouseover",function(){
		 this.setOptions({fillColor: "#00FF00"});
		}); 
		google.maps.event.addListener(polygon,"mouseout",function(){
		 this.setOptions({fillColor: "#333333"});
		}); 
	}
	/*
 	* Functions relating to Rectangle manipulation
 	*/
	function hideRectangle(){
		if (marker_list[0] && marker_list[1]){
			marker_list[0].setMap(null);
			marker_list[1].setMap(null);
		}
		rectangle.setMap(null);
		rectangle = false;
		document.getElementById(pointLayer).innerHTML = "";
	}
	function drawRectangle(){
		if (polygon || polyline){
			hidePoly();
		}
		if (rectangle){
			hideRectangle();
		}	
		marker_list = [];
		marker_list[0] = new google.maps.Marker({
		  map: map,
		  position: new google.maps.LatLng(72, -170),
		  draggable: true,
		  icon: "http://maps.google.com/mapfiles/ms/icons/blue.png"
		});
		marker_list[1] = new google.maps.Marker({
		  map: map,
		  position: new google.maps.LatLng(53, -140),
		  draggable: true,
		  icon: "http://maps.google.com/mapfiles/ms/icons/blue.png"
		});
		
		google.maps.event.addListener(marker_list[0], 'drag', dragRectangle);
		google.maps.event.addListener(marker_list[1], 'drag', dragRectangle);
		rectangle = new google.maps.Rectangle({
		  map: map,
		  fillColor: "#0000ff",
		  fillOpacity: "0.2",
		  strokeColor: "#0000ff",
		  strokeWeight: "3"
		});

		var latLngBounds = new google.maps.LatLngBounds(
		  marker_list[0].getPosition(),
		  marker_list[1].getPosition()
		);
		rectangle.setBounds(latLngBounds);
		updatePointList();
	}
	function dragRectangle() {
		var latLngBounds = new google.maps.LatLngBounds(
		  marker_list[0].getPosition(),
		  marker_list[1].getPosition()
		);
		rectangle.setBounds(latLngBounds);
		updatePointList();
	}
	function updatePointList(){
		if (document.getElementById(pointLayer)){
			var coordinate_list = "";
			for (var i = 0; i < marker_list.length; i++){
				coordinate_list += "P" + (i + 1) + ": " + marker_list[i].getPosition() + "\n";
			}
			document.getElementById(pointLayer).innerHTML = coordinate_list;
		}
	}
	function setPointLayer(layername){
		pointLayer = layername;
	}
