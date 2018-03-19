<?php 
include_once ROOTPATH.'/modules/agent/inc/agent.php';
	$dates = date('m');
	$wh_str = '';
	/*$rows = $agent_cls->getRows('SELECT  agt_1.type_id, agt_typ.title,
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable('agent').' AS agt_1 INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt_typ
						ON agt_1.type_id = agt_typ.agent_type_id AND agt_typ.title = "vendor") AS vendor,
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable('agent').' AS agt_1 INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt_typ
						ON agt_1.type_id = agt_typ.agent_type_id AND agt_typ.title = "buyer") AS buyer,
						
						(SELECT COUNT(*) 
						FROM '.$agent_cls->getTable('agent').' AS agt_1 INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt_typ
						ON agt_1.type_id = agt_typ.agent_type_id AND agt_typ.title = "partner") AS partner
						
					FROM '.$agent_cls->getTable('agent').' AS agt_1 INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt_typ 
						ON agt_1.type_id = agt_typ.agent_type_id GROUP BY  agt_1.type_id',true);*/
			//echo $agent_cls->sql;		
	//nh edit
    $rows = $agent_cls->getRows('SELECT agt.name,count(ag.agent_id) as count
                                   FROM '.$agent_cls->getTable().' AS ag
                                   INNER JOIN '.$agent_cls->getTable('agent_type').' AS agt
                                   ON ag.type_id = agt.agent_type_id
                                   WHERE agt.active = 1
                                         AND ag.is_active = 1
                                   GROUP BY agt.title',true);
    $data = array();
	if (is_array($rows) and count($rows)>0) {
		foreach ($rows as $row) {
			/*$data[] = array('type' =>'pie'  , 'data' => array((int)$row['vendor'] , (int)$row['buyer'] , (int)$row['partner'] ));
			$vendor = (int)$row['vendor'];
			$buyer = (int)$row['buyer'];
			$partner = (int)$row['partner'];*/
            $data[$row['name']] = $row['count'];
		}
	}	
?>
 		
<script type="text/javascript">
   /*var dataAgent = [['<?php echo 'Vendor' ?>' , <?php echo $vendor ?> ], ['<?php echo 'Buyer' ?>' , <?php echo $buyer ?>]
                               ,['<?php echo 'Partner' ?>' , <?php echo $partner ?>]];*/
   var dataAgent = [<?php 
                          foreach ($data as $k=>$val){
                                $arr[] = ("['{$k}',{$val}]");
                          }
                          echo implode(',',$arr);
                   ?>];
</script> 	<!-- End Chart Statistics Agent Type -->