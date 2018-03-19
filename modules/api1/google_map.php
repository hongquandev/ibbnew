
<?php
$height = 500;
 if(isset($_GET['h']))
     $height = (int)$_GET['h'];

if($height==0){
    $height =500;
}
include_once '../property/google_map.php';
?>
<style>
 #map_canvas{height: <?echo $height;?>px !important; width: 100% !important;}
</style>