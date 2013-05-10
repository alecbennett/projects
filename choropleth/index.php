<?php 
	require_once("../../template.php");	
	$page = new webPage("Generating Web Map Choropleths");
	$page->SiteHeader();
?>
<div style="width: 100%; height:60px; margin-bottom: 10px;"><div style="display: inline-block;"><h1>Generating Web Map Choropleths</h1></div><div style="display: inline-block; width: 234px; height: 60px; float: right;"><script type="text/javascript"><!--
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
	<div id="map_wrapper" style="width: 100%; position: relative; height: 500px;">
		<div id="map" style="border: 1px solid #999; height: 100%; width: 100%; float: right;">
			<noscript><div class="noScriptDemo">JavaScript Must Be Enabled for this demo</div></noscript>	
		</div>
		<div style="position: absolute; bottom: 10px; left: 10px;">
		</div>
	</div>

	<div>
		<p>
		Application of the Choropleth is added by using the following function from <a href="https://github.com/alecbennett/jsmaptools">jsmaptools</a>: <pre><code>.addChoropleth('property','color1','color2')</code></pre> The following 3 lines load a GeoJSON file and apply the Choropleth for this map:
		</p>
<pre style="font-size: 14px;"><code>
var mt = new MapTools(map);
mt.readGeoJSON("us-states.json");  //Explained <a href="/projects/loadgeojson/">here</a>.
mt.applyChoropleth('income','#ffffcc', '#006837');
</pre></code>
	<p>The majority of the work in this case is done through the applyChoropleth function. The function takes as arguments the property you intend to apply the gradient to, the low value color, and the high value color, currently in 6 digit hex code, such as: <code>#000000</code>. The function loops through each feature to find the min/max of the desired property.  After that, it applies the proper color value to the gradient between the two end values. The function itself looks like this:</p>
<pre style="font-size: 14px;"><code>
function applyChoropleth(prop, lowcolor, highcolor){
	var min;
	var max;
	var min_r = parseInt(lowcolor.substring(1,3), 16);
	var max_r = parseInt(highcolor.substring(1,3), 16);
	var min_g = parseInt(lowcolor.substring(3,5), 16);
	var max_g = parseInt(highcolor.substring(3,5), 16);
	var min_b = parseInt(lowcolor.substring(5,7), 16);
	var max_b = parseInt(highcolor.substring(5,7), 16);
	/* Find min &amp; /max */
	$.each(this.features, function(i,v){
		var pv = eval("v.properties." + prop);
		if (i == 0){
			min = pv;
			max = pv;
		} else {
			if (pv &lt; min){ min = pv; }
			if (pv &gt; max){ max = pv; }
		}
	});
	/* Determine scaling factor for range of colors */
	var diff = max - min;
	var scale_r = 1 / (diff) * (max_r - min_r);
	var scale_g = 1 / (diff) * (max_g - min_g);
	var scale_b = 1 / (diff) * (max_b - min_b);
	/* Loop and apply color to each polygon */
	$.each(this.features, function(i,v){
		// Store property value
		var pv = eval("v.properties." + prop);
		// Determine color value within range
		if (scale_r &lt; 0){
			//Check if scaling from a high hex value down
			var c_r = Math.round(max_r - (max - pv) * scale_r).toString(16);
		} else {
			//If scaling from low hex value up
			var c_r = Math.round((pv - min) * scale_r + min_r).toString(16); 
		}
		if (scale_g &lt; 0){
			var c_g = Math.round(max_g - (max - pv) * scale_g).toString(16);
		} else {
			var c_g = Math.round((pv - min) * scale_g + min_g).toString(16);
		}
		if (scale_b &lt; 0){
			var c_b = Math.round(max_b - (max - pv) * scale_b).toString(16);
		} else {
			var c_b = Math.round((pv - min) * scale_b + min_b).toString(16);
		}
		// Add padding if needed
		if (c_r.length &lt; 2){ c_r = "0" + c_r; }
		if (c_g.length &lt; 2){ c_g = "0" + c_g; }
		if (c_b.length &lt; 2){ c_b = "0" + c_b; }
		// Rebuild the hex color string
		var colorString = eval("'#" + c_r + c_g + c_b + "'");
		// Apply the coloring
		v.p.setStyle({ fillColor: colorString, fillOpacity: '1.00', color: '#ffffff' });
		// Prevent it from miscoloring after hover/mouseout
		v.p.on('mouseout', function(){ this.setStyle({fillColor:  colorString})});
	});
}

</code></pre>

	<p>Full source code is available via the projects repo at github.com <a href="https://github.com/alecbennett/projects/tree/master/choropleth">here</a>. The GeoJSON file used here is based on the "us-states" file produced by <a href="http://bost.ocks.org/mike/">Mike Bostock</a> from his <a href="http://bost.ocks.org/mike/leaflet/">D3 + Leaflet</a> tutorial.  Data was then obtained from Wikipedia for Mean annual household income in 2011, <a href="http://en.wikipedia.org/wiki/List_of_U.S._states_by_income">here</a>.</p>
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
			mt.applyChoropleth('income','#ffffcc', '#006837');
			for (var i = 0; i < mt.features.length; i++){
				if (mt.features[i].type == "Polygon" || mt.features[i].type == "MultiPolygon"){
					mt.features[i].p.bindPopup("<div style='font-size: 14px;'>2011 Mean annual household income " + mt.features[i].properties.name + ": <b>$" + mt.features[i].properties.income.toString().substring(0,2) + "," + mt.features[i].properties.income.toString().substring(2,5) + "</b>.</div>");
				}
			}
		});

	</script>
<?php $page->SiteFooter(); ?>
