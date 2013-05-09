<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<div style="width: 100%; height:60px; margin-bottom: 10px;"><div style="display: inline-block;"><h1>GeoJSON Multi(Polygon) Layers</h1></div><div style="display: inline-block; width: 234px; height: 60px; float: right;"><script type="text/javascript"><!--
google_ad_client = "ca-pub-1195803658795155";
/* ProjectAd */
google_ad_slot = "2032017167";
google_ad_width = 234;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div></div>
	<script type="text/javascript" src="../jsmaptools/js/jsmaptools.js"></script>
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.css" />
	 <script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js"></script>
	<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js" type="text/javascript"></script>
	<div id="map_wrapper" style="width: 100%; position: relative; height: 500px;">
		<div id="map" style="border: 1px solid #999; height: 100%; width: 100%; float: right;">
			<noscript><div class="noScriptDemo">JavaScript Must Be Enabled for this demo</div></noscript>	
		</div>
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
			map = new L.Map('map');
			var apikey = 'ea24b4e5fd234fe08d4250a1f833b308';
			var mapUrl='http://{s}.tile.cloudmade.com/' + apikey + '/94389/256/{z}/{x}/{y}.png';
			var mapAttrib='Map data © OpenStreetMap contributors';
			var mapLayer = new L.TileLayer(mapUrl, {minZoom: 3, maxZoom: 17, attribution: mapAttrib});
			map.setView(new L.LatLng(50, -115),3);
			map.addLayer(mapLayer);

			var mt = new MapTools(map);
			mt.readGeoJSON("us-states.json");
			mt.applyChoropleth('density','#ffff00', '#0000ff');
		});

	</script>
<?php $page->SiteFooter(); ?>
