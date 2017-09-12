<html>

<head>

<title>Multiple Location Marker in One Google Map</title>
<!-- Mobile viewport optimized -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link media="all" type="text/css" href="assets/dashicons.css" rel="stylesheet">
<link media="all" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet">
<link rel='stylesheet' id='style-css'  href='style.css' type='text/css' media='all' />
<script type='text/javascript' src='assets/jquery.js'></script>
<script type='text/javascript' src='assets/jquery-migrate.js'></script>

<?php /* === GOOGLE MAP JAVASCRIPT NEEDED (JQUERY) ==== */ ?>
<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
<script type='text/javascript' src='assets/gmaps.js'></script>

</head>

<body>
	<div id="container">

		<article class="entry">


			<div class="entry-content">

				<?php /* === THIS IS WHERE WE WILL ADD OUR MAP USING JS ==== */ ?>
				<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
					<div id="google-map" class="google-map">
					</div><!-- #google-map -->
				</div>

				<?php /* === MAP DATA === */ ?>
				<?php
				$zipcode = array();

				$zipcode[] = '54490';
				$zipcode[] = '35470';
				$zipcode[] = '21120';
				$zipcode[] = '59130';
				$zipcode[] = '69460';
				$zipcode[] = '07100';
				$zipcode[] = '83500';
				$zipcode[] = '77710';
				$zipcode[] = '08140';
				$zipcode[] = '67400';
				$zipcode[] = '91440';
				$zipcode[] = '75018';
				$zipcode[] = '60110';
				$zipcode[] = '78520';
				$zipcode[] = '42660';
				$zipcode[] = '54790';
				$zipcode[] = '91200';
				$zipcode[] = '49300';
				$zipcode[] = '09250';
				$zipcode[] = '80800';
				$zipcode[] = '31880';
				$zipcode[] = '91220';
				$zipcode[] = '91210';
				$zipcode[] = '61500';
				$zipcode[] = '79220';
				$zipcode[] = '91400';
				$zipcode[] = '60870';
				$zipcode[] = '14000';
				$zipcode[] = '79370';
				$zipcode[] = '59270';
				$zipcode[] = '07290';
				$zipcode[] = '44210';
				$zipcode[] = '17230';
				$zipcode[] = '77940';
				$zipcode[] = '60400';
				$zipcode[] = '28230';
				$zipcode[] = '92160';
				$zipcode[] = '76320';
				$zipcode[] = '03000';
				$zipcode[] = '30210';
				$zipcode[] = '77650';
				$zipcode[] = '91000';
				$zipcode[] = '86530';
				$zipcode[] = '56390';
				$zipcode[] = '17330';
				$zipcode[] = '71570';
				$zipcode[] = '44000';
				$zipcode[] = '74210';
				$zipcode[] = '22000';
				$zipcode[] = '94000';
				$zipcode[] = '57280';
				$zipcode[] = '91300';		

				$loc = array();

				foreach ($zipcode as $z) {
						$address = $z.', france';
						$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=true');
						$coordinates = json_decode($coordinates);
						$lat=$coordinates->results[0]->geometry->location->lat;
						$lng=$coordinates->results[0]->geometry->location->lng;

						//echo $lat.' - '.$lng.'<br />';

					$loc[] = array(
					'google_map' => array(
						'lat' => $lat,
						'lng' => $lng,
					),
					'location_address' => 'Puri Anjasmoro B1/22 Semarang',
					'location_name'    => 'Loc A',
				);

				}

				$locations = array();

				/* Marker #1 */
				$locations[] = array(
					'google_map' => array(
						'lat' => '49.3340028',
						'lng' => '5.756215',
					),
					'location_address' => 'Puri Anjasmoro B1/22 Semarang',
					'location_name'    => 'Loc A',
				);

				/* Marker #2 */
				$locations[] = array(
					'google_map' => array(
						'lat' => '-6.974426',
						'lng' => '110.38498099999993',
					),
					'location_address' => 'Puri Anjasmoro P5/20 Semarang',
					'location_name'    => 'Loc B',
				);

				/* Marker #3 */
				$locations[] = array(
					'google_map' => array(
						'lat' => '-7.002475',
						'lng' => '110.30163800000003',
					),
					'location_address' => 'Ngaliyan Semarang',
					'location_name'    => 'Loc C',
				);
				?>


				<?php /* === PRINT THE JAVASCRIPT === */ ?>

				<?php
				/* Set Default Map Area Using First Location */
				$map_area_lat = isset( $loc[0]['google_map']['lat'] ) ? $loc[0]['google_map']['lat'] : '';
				$map_area_lng = isset( $loc[0]['google_map']['lng'] ) ? $loc[0]['google_map']['lng'] : '';
				?>

				<script>
				jQuery( document ).ready( function($) {

					/* Do not drag on mobile. */
					var is_touch_device = 'ontouchstart' in document.documentElement;

					var map = new GMaps({
						el: '#google-map',
						lat: '<?php echo $map_area_lat; ?>',
						lng: '<?php echo $map_area_lng; ?>',
						scrollwheel: false,
						draggable: ! is_touch_device
					});

					/* Map Bound */
					var bounds = [];

					<?php /* For Each Location Create a Marker. */
					foreach( $loc as $location ){
						$name = $location['location_name'];
						$addr = $location['location_address'];
						$map_lat = $location['google_map']['lat'];
						$map_lng = $location['google_map']['lng'];
						?>
						/* Set Bound Marker */
						var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
						bounds.push(latlng);
						/* Add Marker */
						map.addMarker({
							lat: <?php echo $map_lat; ?>,
							lng: <?php echo $map_lng; ?>,
							title: '<?php echo $name; ?>',
							infoWindow: {
								content: '<p><?php echo $name; ?></p>'
							}
						});
					<?php } //end foreach locations ?>

					/* Fit All Marker to map */
					map.fitLatLngBounds(bounds);

					/* Make Map Responsive */
					var $window = $(window);
					function mapWidth() {
						var size = $('.google-map-wrap').width();
						$('.google-map').css({width: size + 'px', height: (size/2) + 'px'});
					}
					mapWidth();
					$(window).resize(mapWidth);

				});
				</script>


			</div><!-- .entry-content -->

		</article>

	</div><!-- #container -->
	<footer id="footer">
		<p>&#169; <a title="Creative WordPress Developer" href="https://genbu.me/">Genbu Media</a></p>
	</footer>
</body>

</html>

