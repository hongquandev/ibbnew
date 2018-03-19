<?php 
    include_once ROOTPATH.'/modules/banner/inc/banner.php';
	
	$rows = $banner_cls->getRows('SELECT banner_name, views
	                              FROM '.$banner_cls->getTable().' WHERE views > 0
								  AND status = 1 AND agent_status = 1
								  ORDER BY views DESC
								  LIMIT 0,15', true);
    $data = array();
    $category = array();
	if (is_array($rows) and count($rows) > 0){
		foreach($rows as $row) {
                $category[] = $row['banner_name'];
				$data[] = array('name' => $row['banner_name'], 'data' => array((int)$row['views']));
		}
	}

?>
<script type="text/javascript">
var dataBanner = <?php echo json_encode($data) ?>;
var categories = <?php echo json_encode($category) ?>;
</script>

	
