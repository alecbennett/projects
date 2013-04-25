<?php 
	require_once("../../template.php");	
	$page = new webPage("Polygon Selection");
	$page->SiteHeader();
?>
<h1>Polygon Selection Tool</h1>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"> </script>
	<script type="text/javascript" src="js/poly.js"></script>
	<script type="text/javascript">
		google.maps.event.addDomListener(window, 'load', init);
		setPointLayer("pointDisplay");
	</script>	
	<div id="map_wrapper" style="position: relative; height: 600px;">
		<div id="map_canvas" style="border: 1px solid #999; height: 500px; width: 550px; position: relative; float: right;"></div>
		<div style="width: 400px;">
			<p>Draw a polygon by clicking on the "Draw Polygon" button, and then selecting points on the map.  Close the polygon by selecting the first point on the map (the one with the dot).</p>
			<textarea type="text" id="pointDisplay" readonly="readonly" style="width: 395px; height: 300px;" ></textarea>
			<input type="button" onclick="drawPolygon();" value="Draw Polygon" style="margin-top: 5px; width: 400px; height: 75px;" />
		</div>
		<div id="pointDisplay"></div>
	</div>
<?php $page->SiteFooter(); ?>
