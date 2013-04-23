<?php
	require_once("../../template.php");
        $page = new webPage("Earthquake Activity Map");
        $page->SiteHeader(); ?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
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
				loadData('http://earthquake.usgs.gov/earthquakes/feed/v0.1/summary/1.0_week.geojsonp');
				window.setInterval(function() {
					loadData('http://earthquake.usgs.gov/earthquakes/feed/v0.1/summary/all_hour.geojsonp');
				}, 60000);

			});
		</script>
		<div><h2>Earthquake Activity Map (<?php echo date("F jS, Y h:i:s A T"); ?>)</h2></div>
		<div id="mapcanvas" style="height: 600px; width: 980px; margin: auto; border: 1px solid gray;"></div>
		<div>
			<p>The Earthquake Activity Map draws on data from the <a href="http://earthquake.usgs.gov" target="new">USGS</a> for incident information.  Data is obtained via the GeoJSON format, using JSONP, and placed as markers in the Google Maps API.  Currently, data is only pulled at the time of the page load.  Future updates may include re-polling of the hourly or minute data. Code is stored on Github <a href="https://github.com/alecbennett/projects/tree/master/eam">here</a></p>
		</div>
<?php $page->SiteFooter(); ?>


