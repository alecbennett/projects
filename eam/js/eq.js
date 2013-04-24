var map;
var loaded = false;
var marker;
var marker2;
var markersArray = [];
var infoArray = [];
function resize(){ }

function initialize() {
	var latlng = new google.maps.LatLng(50.397, -110.644);

	var myOptions = {
		zoom: 3,
		minZoom: 3,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
	//loadMapMarkers();
}
function loadData(equrl){
	$.ajax({
		url: equrl,
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
					if (loaded == true){
						var latLng = new google.maps.LatLng(eqjson.features[i].geometry.coordinates[1],
                                              eqjson.features[i].geometry.coordinates[0]);
						map.setZoom(8);
						map.panTo(latLng);
					}
				}
				loaded = true;
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
		var timeDiff = (new Date().getTime()) - myDate;
		var myZ = myMag;
		if (timeDiff < (3600*3*1000)){
			var myIcon = "img/red_";
			myZ += 20;
		} else if (timeDiff < (3600*24*1000)){
			var myIcon = "img/dodgerblue_";
			myZ += 10;
		} else {
			var myIcon = "img/yellow_";
		}
		if (myMag < "1.0"){ myIcon += "1"; }
		else if (myMag < "2.0"){ myIcon += "2"; }
		else if (myMag < "3.0"){ myIcon += "3"; }
		else if (myMag < "4.0"){ myIcon += "4"; }
		else if (myMag < "5.0"){ myIcon += "5"; }
		else if (myMag < "6.0"){ myIcon += "6"; }
		else if (myMag < "7.0"){ myIcon += "7"; }
		else if (myMag < "8.0"){ myIcon += "8"; }
		else if (myMag >= "8.0"){ myIcon += "9"; }
		myIcon += ".png";
		marker = new google.maps.Marker({
		  map: map,
		  position: new google.maps.LatLng(myLat, myLong),
		  draggable: false,
		  icon: "http://maps.google.com/mapfiles/ms/icons/red.png",
		  icon: myIcon,
		  zIndex: myZ,
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
