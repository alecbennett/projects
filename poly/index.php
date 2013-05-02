<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<div style="width: 100%; height:60px; margin-bottom: 10px;"><div style="display: inline-block;"><h1>Polygon Selection Tool</h1></div><div style="display: inline-block; width: 234px; height: 60px; float: right;"><script type="text/javascript"><!--
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
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
	<script type="text/javascript" src="js/poly.js"></script>
	<script type="text/javascript">
		google.maps.event.addDomListener(window, 'load', init);
		setPointLayer("pointDisplay");
	</script>	
	<div id="map_wrapper" style="position: relative; height: 600px;">
		<div id="map_canvas" style="border: 1px solid #999; height: 500px; width: 550px; position: relative; float: right;">
			<noscript><div class="noScriptDemo">JavaScript Must Be Enabled for this demo</div></noscript>	
		</div>

		<div style="width: 400px;">
			<p>Draw a polygon by clicking on the "Draw Polygon" button, and then selecting points on the map.  Close the polygon by selecting the first point on the map (the one with the dot).  Output is now produced in GeoJSON format.</p>
			<textarea type="text" id="pointDisplay" readonly="readonly" style="width: 395px; height: 275px;" ></textarea>
			<input type="button" onclick="drawPolygon();" value="Draw Polygon" style="margin-top: 5px; width: 400px; height: 75px;" />
		</div>
		<div id="pointDisplay"></div>
	</div>
<?php $page->SiteFooter(); ?>
