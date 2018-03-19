<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example: Controls</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
    var geocoder;
    var map;
    function initMap() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
            zoom: 12,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        <?php
            $address =  str_replace(',','',$_GET['address']);
            $address = str_replace(' ','+',$address);
        ?>
        var orAddress = '<?php echo $_GET['address'];?>';
        var address = '<?php echo $address;?>';

        var contentString = "<div class='box'><label>Property address :</label>" + orAddress + "</div>"
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });

        geocoder.geocode({'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            title: 'Introduce'
                        });
                        infowindow.open(map,marker);
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
        });
    }
    </script>
    <style type="text/css">
	.box{
		font-size:12px;
		width:250px;
	}
	.box label{
		font-weight:bold;
		text-decoration:underline;
		display:block;
	}
	#map_canvas{width: 620px;height: 360px;}
	</style>
  </head>
  <body style="padding: 0;margin: 0" onload="initMap()">
    <div style="padding: 0;margin: 0" id="map_canvas" class="map_canvas"></div>
  </body>
</html>




