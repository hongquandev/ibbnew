<?php
include_once ROOTPATH.'/includes/pagging.class.php';

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}


switch ($action_ar[1]) {
	case 'buyer':
	case 'vendor':
	case 'partner':
		$rows = $agent_cls->getRows("SELECT agt.* 
					FROM ".$agent_cls->getTable()." AS agt,".$agent_cls->getTable('agent_type')." AS agt_typ
					WHERE agt.type_id = agt_typ.agent_type_id AND agt_typ.title = '".$agent_cls->escape($action_ar[1])."'",true);
		
		if ($agent_cls->hasError()) {
		
		} else if (is_array($rows) and count($rows) > 0) {
			//BEGIN FOR PAGGING
			$p = (int)preg_replace('#[^0-9]#','',isset($_GET['p']) ? $_GET['p'] : 1);
			if ($p <= 0) {
				$p = 1;
			}
			$len = 20;
			//END		
			$total_row = $agent_cls->getFoundRows();
			$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' per page)';
			
			$pag_cls->setTotal($total_row)
					->setPerPage($len)
					->setCurPage($p)
					->setLenPage(10)
					->setUrl('/?module=agent&action=list-'.$action_ar[1])
					->setLayout('link_simple');
			
			$smarty->assign('data',$rows);
			$smarty->assign('pag_str',$pag_cls->layout());		
		}
	break;	
}
?>