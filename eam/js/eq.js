var map;
var marker;
var marker2;
var markersArray = [];
var infoArray = [];
function resize(){ }

function initialize() {
	var latlng = new google.maps.LatLng(50.397, -110.644);

	var myOptions = {
		zoom: 3,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
	//loadMapMarkers();
}
function loadData(){
	$.ajax({
		url: 'http://earthquake.usgs.gov/earthquakes/feed/v0.1/summary/1.0_week.geojsonp',
		dataType: 'jsonp',
		jsonp: 'callback',
		jsonpCallback: 'eqfeed_callback',
		success: function(data){// your code here
			function eqfeed_callback(eqjson){
				for (var i = 0; i < eqjson.features.length; i++){
					addMarker(
						eqjson.features[i].geometry.coordinates[1],
						eqjson.features[i].geometry.coordinates[0],
						eqjson.features[i].properties.mag,
						eqjson.features[i].properties.place,
						eqjson.features[i].properties.time,
						eqjson.features[i].properties.url
					);
				}
			}
		eqfeed_callback(data);
	    }
	});
}
function addMarker(myLat,myLong,myMag,myLoc,myDate,myEvent){
	if (myMag >= minMag){
		var myLatLong = new google.maps.LatLng(myLat,myLong);
		var myLink = myEvent;
		var myHtml = "<div style='color: #777777; margin: 10px;'>";
			myHtml += "<div style='font-weight: bold; font-size: 13px; color: #000000'>" + myLoc + "</div>";
			myHtml += "<div style='font-size: 14px; margin-top: 5px;'>Magnitude: <span style='color: #000000;'>" +  myMag + "</span></div>";
			myHtml += "<div style='font-size: 12px; margin-top: 5px;'>Time: <span style='color: #000000;'>" +  myDate + "</span></div>";
			myHtml += "<div style='font-size: 12px;'>Event ID: <span style='color: #000000;'><a href='" + myLink + "' target='new'>" +  myEvent + "</a></span></div>";
			myHtml += "</div>";
		var myIcon = "earthquake_";
		if (myMag < "3.0"){ myIcon += "3"; }
		else if (myMag < "4.0"){ myIcon += "4"; }
		else if (myMag < "5.0"){ myIcon += "5"; }
		else if (myMag < "6.0"){ myIcon += "6"; }
		else if (myMag < "7.0"){ myIcon += "7"; }
		else if (myMag >= "7.0"){ myIcon += "max"; }
		myIcon += ".png";
		marker = new google.maps.Marker({
		  map: map,
		  position: new google.maps.LatLng(myLat, myLong),
		  draggable: false,
		  icon: "http://maps.google.com/mapfiles/ms/icons/red.png",
		  icon: myIcon,
		  html: myHtml
		});
		 var infowindow = new google.maps.InfoWindow({  
		  content: myLoc
		});  
		markersArray.push(marker);
		infoArray.push(infowindow);

		    google.maps.event.addListener(markersArray[markersArray.length - 1], 'click', function() {  
			var tmp_info = infoArray[infoArray.length - 1];
			tmp_info.setContent(this.html);  
			tmp_info.open(map, this);  
	    });  
	}
}
