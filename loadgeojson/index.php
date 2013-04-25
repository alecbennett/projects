<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<h1>GeoJSON Polygon Layers</h1>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
	<script type="text/javascript" src="../../js/jsplay.js"></script>
	<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js" type="text/javascript"></script>
	<div id="map_wrapper" style="width: 100%; position: relative; height: 500px;">
		<div id="map_canvas" style="border: 1px solid #999; height: 100%; width: 100%; float: right;"></div>

	</div>

	<div>
		<p>Loading Polygon and MultiPolygons from GeoJSON files using jQuery, and populating a jsMapTools object.  This loads a GeoJSON file for the USA, containing MultiPolygons which include Alaska, Hawaii, and the Continental US.</p>
		<p>
			The core of this is in using the jQuery $.getJSON() function.  The file itself is loaded into an object (in this case "layers") and then you can iterate through the array for features.  Each feature has one set of geometry with one or more coordinates.
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
	<p>Full source code is available via the projects repo at github.com <a href="https://github.com/alecbennett/projects/tree/master/loadgeojson">here</a></p>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){
			map = new google.maps.Map(document.getElementById('map_canvas'), {
				'zoom': 4,
				'center': new google.maps.LatLng(63.5, -147),
				'mapTypeId': google.maps.MapTypeId.ROADMAP
			});
			google.maps.event.addListenerOnce(map, 'idle', function(){
				var mt = new MapTools(map);
				mt.readGeoJSON("my.json");
			});
		});

	</script>
<?php $page->SiteFooter(); ?>
