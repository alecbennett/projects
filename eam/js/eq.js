var map;
var loaded = false;
var num = ( 3600 * 24 * 365 * 40);
var markersArray = [];

function initialize() {
	map = new L.Map('map');
	var apikey = 'ea24b4e5fd234fe08d4250a1f833b308';
	var osmUrl='http://{s}.tile.cloudmade.com/' + apikey + '/94389/256/{z}/{x}/{y}.png';
	var osmAttrib='Map data © OpenStreetMap contributors';
	var osm = new L.TileLayer(osmUrl, {minZoom: 3, maxZoom: 12, attribution: osmAttrib});		
	map.setView(new L.LatLng(50, -115),3);
	map.addLayer(osm);
}
function loadData(equrl){
	$.ajax({
		url: equrl,
		dataType: 'jsonp',
		jsonp: 'callback',
		jsonpCallback: 'eqfeed_callback',
		success: function(data){
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
					if (loaded == true && eqjson.features[i].properties.mag >= minMag){
						map.panTo([eqjson.features[i].geometry.coordinates[1], eqjson.features[i].geometry.coordinates[0]]);
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
		var myLatLong = new L.LatLng(myLat,myLong);
		var myLink = myEvent;
		var myHtml = "<div style='color: #777777; padding: 5px;margin: 10px;'>";
			myHtml += "<div style='font-weight: bold; font-size: 13px; color: #000000'>" + myLoc + "</div>";
			myHtml += "<div style='font-size: 14px; margin-top: 5px;'>Magnitude: <span style='color: #000000;'>" +  myMag + "</span></div>";
			myHtml += "<div style='font-size: 12px; margin-top: 5px;'>Time: <span style='color: #000000;'>" +  myDate + "</span></div>";
			myHtml += "<div style='font-size: 12px;'>Event ID: <span style='color: #000000;'><a href='" + myLink + "' target='new'>" +  myEvent + "</a></span></div>";
			myHtml += "</div>";
		var timeDiff = (new Date().getTime()) - myDate;
		var myZ = myMag;
		if (timeDiff < (3600*3*1000)){
                       var myIcon = "img/red_";
                       var iconColor = "red";
               } else if (timeDiff < (3600*24*1000)){
                       var myIcon = "img/dodgerblue_";
                       var iconColor = "blue";
               } else {
                       var myIcon = "img/yellow_";
                       var iconColor = "yellow";
               }
		myZ = 10 + (myDate - num);
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
		var mapIcon = L.icon({
		    iconUrl: myIcon,		
		});
		var circle = L.circle([51.508, -0.11], 500, {
		    color: iconColor,
		    fillColor: iconColor,
		    fillOpacity: 0.5
		}).addTo(map);
		var marker = L.marker([myLat, myLong], {icon: mapIcon}).addTo(map);
		marker.bindPopup(myHtml);
		markersArray.push(circle);
	}
}
