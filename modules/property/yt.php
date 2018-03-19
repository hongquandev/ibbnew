<?php
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include_once 'inc/property.php';
$id = @$_REQUEST['id'];
if (strlen($id) > 0) {
	$data = array('file_name' => $id, 'type' => 'video-youtube', 'active' => 1);
	$media_cls->insert($data);
	$media_id = $media_cls->insertId();
	$data = array('property_id' => @$_SESSION['property']['id'],'media_id'=>$media_id);
	$property_media_cls->insert($data);
}				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
	<div id="yt-id"><?php echo $id;?></div>
    <script>
	parent.getYTId();
	</script>
</body>
</html>
