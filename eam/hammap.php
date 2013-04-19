<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/plugins.js"></script>
		<script type="text/javascript">
		   google.maps.event.addDomListener(window, 'load', initialize);
			$(window).resize(resize);
			var map;
			var marker;
			var marker2;
			var markersArray = [];
			var infoArray = [];
			function resize(){ }
			function initialize() {
			    var latlng = new google.maps.LatLng(64, -150);
			    var myOptions = {
			      zoom: 4,
			      center: latlng,
			      mapTypeId: google.maps.MapTypeId.ROADMAP
			    };
			    map = new google.maps.Map(document.getElementById("mapcanvas"),
				myOptions);
			addMarker(64.8, -148.0, "Ester Dome &amp; Fairbanks Repeater System", "146.88, 146.94, 147.09, 147.12, 147.30, 224.88, 444.80");
			addMarker(65.0, -146.4, "Chena Dome Repeater System", "146.79");
			addMarker(63.7, -145.7, "Donnelly Dome Repeater System", "146.82");
			addMarker(64.3, -146.5, "Canyon Creek Repeater System", "146.76, 444.90");
			addMarker(63.6, -144.0, "Knob Ridge/Dot Lake Repeater System", "146.88, 224.82");
			addMarker(65.5, -145.5, "Porcupine Dome Repeater System", "146.70");
			addMarker(64.7, -141.7, "Mount Elridge/Eagle Repeater System", "146.94");
			addMarker(63.6, -142.2, "Mount Fairplay Repeater System", "444.70");
			addMarker(64.5, -149.0, "Nenana Repeater System", "147.06");
			addMarker(65.0, -150.7, "Manley Hot Springs Repeater System", "147.03");
			addMarker(63.4, -148.8, "Reindeer Mountain Repeater System", "147.03");
			}
			function addMarker(myLat,myLong,myTitle,myFreq){
					var myLatLong = new google.maps.LatLng(myLat,myLong);
					myHtml = "<div style='margin-right: 15px;'>" + myTitle + "</div>";
					marker = new google.maps.Marker({
					  map: map,
					  position: new google.maps.LatLng(myLat, myLong),
					  draggable: false,
					  html: myHtml
					});
					 var infowindow = new google.maps.InfoWindow({  
					  content: ""
					});  
					markersArray.push(marker);
					infoArray.push(infowindow);

					    google.maps.event.addListener(markersArray[markersArray.length - 1], 'click', function() {  
						var tmp_info = infoArray[infoArray.length - 1];
						tmp_info.setContent(this.html);  
						tmp_info.open(map, this);  
				    });  
			}

			
		</script>

	</head>
	<body>

		<div id="mapcanvas" style="height: 95%; width: 95%; margin: auto; border: 1px solid gray;"></div>
		<div style="width: 1024px;">

		</div>
	</body>

</html>
