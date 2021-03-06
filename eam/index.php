<?php
	require_once("../../template.php");
        $page = new webPage("Earthquake Activity Map");
        $page->SiteHeader(); ?>
		 <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.css" />
		 <script src="http://cdn.leafletjs.com/leaflet-0.5/leaflet.js"></script>
		 <script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>
        	<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet' />	
		<?php
			echo "<script type='text/javascript'>";
				if ($_GET['min']){
					echo "var minMag = ".$_GET['min'].";";
				} else {
					echo "var minMag = 3.0;";
				}
			echo "</script>";
		?>
		<script type="text/javascript" src="js/eq.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){ 
				initialize(); 
				loadData('http://earthquake.usgs.gov/earthquakes/feed/v0.1/summary/all_week.geojsonp');
				window.setInterval(function() {
					loadData('http://earthquake.usgs.gov/earthquakes/feed/v0.1/summary/all_hour.geojsonp');
				}, 60000);
			});
		</script>
		<div style="width: 100%; height:60px; margin-bottom: 10px;"><div style="display: inline-block;"><h2>Earthquake Activity Map (<?php echo date("F jS, Y h:i:s A T"); ?>)</h2></div><div style="display: inline-block; width: 234px; height: 60px; float: right;"><script type="text/javascript"><!--
		google_ad_client = "ca-pub-1195803658795155";
		/* ProjectAd */
		google_ad_slot = "2032017167";
		google_ad_width = 234;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></div></div>
		<div style="position: relative;">
			<div id="map" style="height: 600px; width: 980px; margin: auto; border: 1px solid gray;">
				<noscript><div class="noScriptDemo">JavaScript Must Be Enabled for this demo</div></noscript>	
			</div>
			<div style="position: absolute; bottom: 30px; right: 20px; opacity: 0.6; color: black; background-color: #888888; width: 290px; text-align: center; height: 42px; border: 1px solid black; line-height: 42px; border-radius: 5px; padding: 5px; vertical-align: middle;">
				<img src="img/white_1.png" />
				<img src="img/white_2.png" />
				<img src="img/white_3.png" />
				<img src="img/white_4.png" />
				<img src="img/white_5.png" />
				<img src="img/white_6.png" />
				<img src="img/white_7.png" />
				<img src="img/white_8.png" />
				<img src="img/white_9.png" />
			</div>
		</div>
		<div>
			<p>The Earthquake Activity Map draws on data from the <a href="http://earthquake.usgs.gov" target="new">USGS</a> for incident information.  Data is obtained via the GeoJSON format, using JSONP, and placed as markers in the <a href="http://leafletjs.com">Leaflet</a> API, using <a href="http://www.cloudmade.com">CloudMade</a> styles and <a href="http://www.openstreetmap.org/">OpenStreetMap</a> for the tile layer.  Currently, data is only pulled at the time of the page load.  Future updates may include re-polling of the hourly or minute data. Code is stored on Github <a href="https://github.com/alecbennett/projects/tree/master/eam">here</a></p>
		</div>

<?php $page->SiteFooter(); ?>


