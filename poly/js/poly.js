


// Global variables
	var map;
	var polygon;
	var polyline;
	var point_list = [];
	var marker_list = [];
	var pointLayer = "";

      /**
       * Called on the initial page load.
       */
	function initialize() {
		map = new L.Map('map');
		var apikey = 'ea24b4e5fd234fe08d4250a1f833b308';
		var mapUrl='http://{s}.tile.cloudmade.com/' + apikey + '/94389/256/{z}/{x}/{y}.png';
		var mapAttrib='Map data © OpenStreetMap contributors';
		var mapLayer = new L.TileLayer(mapUrl, {minZoom: 3, maxZoom: 12, attribution: mapAttrib});
		map.setView(new L.LatLng(50, -115),3);
		map.addLayer(mapLayer);
      	}
	/*
 	* Functions relating to Polygon manipulation
 	*/
	function startPolygon(){
		if (polygon){
			map.removeLayer(polygon);
			marker_list = [];
			point_list = [];
			updatePointList();
		}
		map.on('click', function(e){
			var marker = new L.marker(e.latlng);
			point_list.push(marker.getLatLng());
			if (marker_list.length == 0){
				marker.on('click', function(e){
					polygon = new L.Polygon(point_list).addTo(map);
					map.removeLayer(polyline);
					map.off('click');
					$.each(marker_list, function(i,v){
						map.removeLayer(marker_list[i]);
					});
				});
				polyline = L.polyline(point_list, {color: 'red'}).addTo(map);
			} else {
				polyline.setLatLngs(point_list);
			}	
			marker_list.push(marker.addTo(map));
			updatePointList();
		});
	}
	function updatePointList(){
		var myJSON = {"type":"FeatureCollection"};
		myJSON.features = [{"type":"Feature"}];
		myJSON.features[0].properties = {"prop0":"value0"};
		myJSON.features[0].geometry = {"type":"Polygon"};
		myJSON.features[0].geometry.coordinates = [[]];
		var jsonString = '{"type":"FeatureCollection",\n  "features":[{\n    "type":"Feature",';
		jsonString += '\n    "properties":{\n      "prop0": "value0"\n    },';
		jsonString += '\n    "geometry":{\n      "type":"Polygon",\n      "coordinates":[[\n';
		if (document.getElementById(pointLayer)){
			if (marker_list.length >= 1){
				myJSON.features[0].geometry.coordinates[0].push([marker_list[0].getLatLng().lng,marker_list[0].getLatLng().lat]);
				jsonString += '        [' + marker_list[0].getLatLng().lng + ',' + marker_list[0].getLatLng().lat + ']';
				for (var i = 1; i < marker_list.length; i++){
					myJSON.features[0].geometry.coordinates[0].push([marker_list[i].getLatLng().lng,marker_list[i].getLatLng().lat]);
					jsonString += ',\n        [' + marker_list[i].getLatLng().lng + ',' + marker_list[i].getLatLng().lat + ']';
				}
				jsonString += '\n      ]]\n    }\n  }]\n}';
				document.getElementById(pointLayer).innerHTML = jsonString;
			} else {
				document.getElementById(pointLayer).innerHTML = "";
			}
		}
	}
	function getArea(pA){
		var A = 0;
		for (var i = 0; i < pA.length; i++){
			var pX = (i+1) % pA.length; //Wrap for end of array issues
			A += pA[i][1]*pA[pX][0] - pA[pX][1]*pA[i][0];
		}
		return 0.5*(Math.abs(A));	
	}
	function setPointLayer(layername){
		pointLayer = layername;
	}
