<?php 
	include_once ROOTPATH.'/modules/property/inc/property.php';
								  
	/*$dates = date('m');
	$sql = 'SELECT COUNT(pro.property_id) as total,
			(SELECT COUNT(property_id) FROM '.$property_cls->getTable().' AS pro
			WHERE pro.auction_sale = 9 
			AND pro.agent_active = 1 AND pro.active = 1
			AND pro.confirm_sold = 0 AND pro.stop_bid = 0
			AND pro.end_time > \''.date('Y-m-d H:i:s').'\'  AND pro.start_time <= \''.date('Y-m-d H:i:s').'\'
			AND pro.pay_status = 2 
			AND pro.property_id IN (SELECT property_id FROM '.$property_cls->getTable('bids').') ) as bids
			FROM '.$property_cls->getTable().' as pro WHERE pro.auction_sale = 9 
			AND pro.agent_active = 1 AND pro.active = 1
			AND pro.confirm_sold = 0 AND pro.stop_bid = 0
			AND pro.end_time > \''.date('Y-m-d H:i:s').'\'  AND pro.start_time <= \''.date('Y-m-d H:i:s').'\'
			AND pro.pay_status = 2 ORDER BY pro.property_id DESC ';
	$rows = $property_cls->getRows($sql,true);
			
		
if (is_array($rows) and count($rows)>0) {
	
	foreach ($rows as $row)
	{	
		$notbid = (int)$row['total'] - (int)$row['bids'];
		$data[] = array('type' =>'pie'  , 'data' => array( (int)$row['bids'] ,$notbid) );	
		$rbids = $row['bids'];
		$rnotbid = $notbid;
	}
}	*/
    $bids = array();
    $category = array();
    $rows = $property_cls->getRows('SELECT pro.property_id, count(pro.property_id) AS bids
                                    FROM '.$property_cls->getTable().' AS pro
                                    LEFT JOIN '.$property_cls->getTable('bids')." AS bid
									ON bid.property_id = pro.property_id
								    WHERE IF(pro.hide_for_live = 1 AND pro.start_time > '".date('Y-m-d H:i:s')."' , 0, 1) = 1
										  AND pro.active = 1
										  AND pro.agent_active = 1
										  AND pro.end_time > '".date('Y-m-d H:i:s')."'
                                          AND pro.confirm_sold = 0
                                          AND pro.auction_sale = 9
                                          AND pro.stop_bid = 0
                                          AND pro.start_time <= '".date('Y-m-d H:i:s')."'
                                          AND pro.pay_status = ".Property::CAN_SHOW."
                                    GROUP BY pro.property_id
                                    ORDER BY bids DESC
                                    LIMIT 0,20
                                    ",true);
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $bids[] = $row['bids'];
            $category[] = $row['property_id'];
        }
    }
?>

<script type="text/javascript">
var dataBids = [<?php echo implode(',',$bids); ?>];
var categoriesBids = [<?php echo implode(',',$category); ?>];

</script> 	<!-- End Chart Statistics Combinations Type Properties Bids  -->
