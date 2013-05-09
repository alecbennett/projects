<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<div style="width: 100%; height:60px; margin-bottom: 10px;"><div style="display: inline-block;"><h1>Generating Dynamic Choropleths</h1></div><div style="display: inline-block; width: 234px; height: 60px; float: right;"><script type="text/javascript"><!--
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
		<p>
		</p>
	<p>Full source code is available via the projects repo at github.com <a href="https://github.com/alecbennett/projects/tree/master/choropleth">here</a>. The GeoJSON file used here is based on the "us-states" file produced by <a href="http://bost.ocks.org/mike/">Mike Bostock</a> from his <a href="http://bost.ocks.org/mike/leaflet/">D3 + Leaflet</a> tutorial.</p>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			map = new L.Map('map');
			var apikey = 'ea24b4e5fd234fe08d4250a1f833b308';
			var mapUrl='http://{s}.tile.cloudmade.com/' + apikey + '/94389/256/{z}/{x}/{y}.png';
			var mapAttrib='Map data © OpenStreetMap contributors';
			var mapLayer = new L.TileLayer(mapUrl, {minZoom: 3, maxZoom: 17, attribution: mapAttrib});
			map.setView(new L.LatLng(52, -115),3);
			map.addLayer(mapLayer);

			var mt = new MapTools(map);
			mt.readGeoJSON("us-states.json");
			mt.applyChoropleth('murder','#ffff00', '#ff0000');
			for (var i = 0; i < mt.features.length; i++){
				if (mt.features[i].type == "Polygon" || mt.features[i].type == "MultiPolygon"){
					mt.features[i].p.bindPopup("<div style='font-size: 14px;'>2011 Murder Rate for " + mt.features[i].properties.name + ": <b>" + mt.features[i].properties.murder + "</b> per 100,000 people</div>");
				}
			}
		});

	</script>
<?php $page->SiteFooter(); ?>
