<style type="text/css">
	#map-canvas { height: 250px; }
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<script type="text/javascript">

var geocoder, map;

function initialize() {
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({
    'address': '<?php echo get_option('address2') . ' ' . get_option('address3'); ?>'
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var myOptions = {
	      center: results[0].geometry.location,
	      disableDefaultUI: true,
	      draggable: false,
	      mapTypeId: google.maps.MapTypeId.ROADMAP,
	      scrollwheel: false,
	      zoom: 12
      }

      map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location,
        title: 'Philadelphia D&M'
      });
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div id="map-canvas"></div>