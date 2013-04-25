<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<h1>GeoJSON Polygon Layers</h1>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
	<script type="text/javascript" src="../jsmaptools/js/jsmaptools.js"></script>
	<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js" type="text/javascript"></script>
	<div id="map_wrapper" style="width: 100%; position: relative; height: 500px;">
		<div id="map_canvas" style="border: 1px solid #999; height: 100%; width: 100%; float: right;"></div>

	</div>

	<div>
		<p>Loading Polygon and MultiPolygons from GeoJSON files using jQuery, and populating a <a href="https://github.com/alecbennett/jsmaptools">jsmaptools</a> object.  This loads a GeoJSON file for the USA, containing MultiPolygons which include Alaska, Hawaii, and the Continental US.</p>
		<p>
			The core of this is in using the jQuery $.ajax() function to load the JSON file, which loads it as an object, and then iterating through the features.  Each feature has one set of geometry with one or more coordinates.  In files with multiple features of different types, things can get a little more tricky, but you can just check the feature.geometry.type property to determine how to handle it.
		</p>
		<p>
		The following snippet uses $.getJSON() to simplify the code, but be warned that this can cause issues with loading since the default is asynchronous. 
		</p>
				<?prettify?>
<pre lang="javascript" style="font-size: 14px;">
$.getJSON(jsonFile, function(layers) {     
	var polyList = [];
	for (var i = 0; i &lt; layers.features[0].geometry.coordinates[0].length; i++){
		var myLatLng = new google.maps.LatLng(layers.features[0].geometry.coordinates[0][i][1], 
						layers.features[0].geometry.coordinates[0][i][0]);
		polyList.push(myLatLng);
	}
	mt.addPolygon(polyList);
});
</pre>
	<p>Full source code is available via the projects repo at github.com <a href="https://github.com/alecbennett/projects/tree/master/loadgeojson">here</a>. The polgyon used in this example is quite simplistic, but the code also works well with much more complex files.</p>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			map = new google.maps.Map(document.getElementById('map_canvas'), {
				'zoom': 3,
				'center': new google.maps.LatLng(53, -120),
				'mapTypeId': google.maps.MapTypeId.ROADMAP
			});
			google.maps.event.addListenerOnce(map, 'idle', function(){
				var mt = new MapTools(map);
				mt.readGeoJSON("usa.geo.json");
				for (var i = 0; i < mt.features.length; i++){
					var feat = mt.features[i];
					if (feat.type == "MultiPolygon"){
						feat.signalPolygons(function(iter, tfeat=feat){
							google.maps.event.addListener(tfeat.polyArray[iter].gMap,"mouseover",function(){
								for (var j = 0; j < tfeat.polyArray.length; j++){
									tfeat.polyArray[j].gMap.setOptions({fillColor: "#ff0000"});
								}
							});
							google.maps.event.addListener(tfeat.polyArray[iter].gMap,"mouseout",function(){
								for (var j = 0; j < tfeat.polyArray.length; j++){
									tfeat.polyArray[j].gMap.setOptions({fillColor: "#222222"});
								}
							});
						});
					}
				}
			});
		});

	</script>
<?php $page->SiteFooter(); ?>
