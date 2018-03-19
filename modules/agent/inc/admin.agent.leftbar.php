<?php
$agent_arr = AgentType_getArr();
$id = (int)restrictArgs(getParam('agent_id',0));
$type = AgentType_getTypeAgent($id);

$menu = array('personal'=>array('key'=>'personal','link' => '?module=agent&action=edit-personal&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Personal detail', 'rel' => implode('-', array($agent_arr['vendor'], $agent_arr['buyer'], $agent_arr['theblock'], $agent_arr['agent']))),
              'personal_partner'=>array('key'=>'personal','link' => '?module=agent&action=edit-personal&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Company detail', 'rel' => $agent_arr['partner']),
              'lawyer'=>array('key'=>'lawyer','link' => '?module=agent&action=edit-lawyer&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Lawyer information', 'rel' => implode('-', array($agent_arr['vendor'], $agent_arr['buyer']))),
              'lawyer_partner'=>array('key'=>'lawyer','link' => '?module=agent&action=edit-lawyer&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Extra Company detail', 'rel' => $agent_arr['partner']),
              'contact'=>array('key'=>'contact','link' => '?module=agent&action=edit-contact&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Contact information', 'rel' => implode('-', array($agent_arr['vendor'], $agent_arr['buyer']))),
              'note'=>array('key'=>'note2','link' => '?module=agent&action=edit-note2&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Admin\'s notes'),
              'company'=>array('key'=>'company','link' => '?module=agent&action=edit-company&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Company detail', 'rel' => implode('-',array($agent_arr['agent'],$agent_arr['theblock']))),
              'site'=>array('key'=>'site','link' => '?module=agent&action=edit-site&agent_id=' . $agent_id . '&token=' . $token, 'title' => 'Advance configurations', 'rel' => $agent_arr['agent']));

$row = $agent_cls->getCRow(array('parent_id'),'agent_id = '.$id);
if ($action_ar[1] == 'personal'){
    $bar_data = array($menu['personal'],$menu['personal_partner'],$menu['lawyer'],$menu['lawyer_partner'],$menu['contact'],$menu['note']);

    if ((is_array($row) and count($row) > 0 and $row['parent_id'] == 0) || !is_array($row)){
            $bar_data = insertArrayIndex($bar_data,$menu['company'],3);
            $bar_data = insertArrayIndex($bar_data,$menu['site'],4);
    }
}else{
    switch ($type){
        case 'partner':
            $bar_data = array($menu['personal_partner'],$menu['lawyer_partner'],$menu['note']);
            break;
        case 'agent':
            $bar_data = array();
            $bar_data[] = $menu['personal'];
            if ($row['parent_id'] == 0){
                $bar_data[] = $menu['company'];
                $bar_data[] = $menu['site'];
            }
            $bar_data[] = $menu['note'];
            break;
        case 'theblock':
            $bar_data = array();
            $bar_data[] = $menu['personal'];
            if ($row['parent_id'] == 0){
                $bar_data[] = $menu['company'];
            }
            $bar_data[] = $menu['note'];
            break;
        default:
            $bar_data = array($menu['personal'],$menu['lawyer'],$menu['contact'],$menu['note']);
            break;
    }
}
$smarty->assign('type',$type);
$title_ar = array('personal' => 'Personal detail',
                  'company'=>'Company detail',
                  'lawyer' => 'Lawyer information',
                  'contact' => 'Contact information',
                  'note' => 'Customer\'s notes',
                  'note2' => 'Admin\'s notes');
	
	$smarty->assign('bar_data', $bar_data);
	$smarty->assign('title',$title_ar[$action_ar[1]]);
    $smarty->assign('id',$id);
?>