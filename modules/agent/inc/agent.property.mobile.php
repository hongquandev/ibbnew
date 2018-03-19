<?php
include_once ROOTPATH.'/modules/package/inc/package.class.php';
include_once ROOTPATH.'/modules/comment/inc/comment.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/note/inc/note.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/general/inc/search_data.php';

// LIST
$action = getParam('action');

$mode = getParam('mode') == 'grid' ? getParam('mode') : 'list';;
$smarty->assign('mode', $mode);
if($action == 'view-dashboard'){
    $title_bar = 'MY RECENT PROPERTIES';
}else{
    $title_bar = 'MY PROPERTY DETAILS';
}

$smarty->assign('property_title_bar', $title_bar);

$form_action = array('module' => 'agent', 'action' => 'view-property');
$form_data['mode'] = $mode;
$form_action = '?' . http_build_query($form_action);
$smarty->assign('form_action', $form_action);

$smarty->assign('agent_id', $_SESSION['agent']['id']);
$smarty->assign('agent_info', $_SESSION['agent']);

$smarty->assign('pag_link', $form_action . '');
$smarty->assign('pag_link_list', $form_action . '&mode=list');
$smarty->assign('pag_link_grid', $form_action . '&mode=grid');
if (getPost('len', 0) > 0) {
    $_SESSION['len'] = (int)restrictArgs(getPost('len'));
}
$len = !empty($_SESSION['len']) ? $_SESSION['len'] : 9;
$smarty->assign('ROOTURL', ROOTURL);
$smarty->assign('len', $len);
$smarty->assign('len_ar', PE_getItemPerPage());

$p = (int)restrictArgs(getQuery('p', 0));
$p = $p <= 0 ? 1 : $p;

$where_str = '';
if (in_array($_SESSION['agent']['type'],array('theblock','agent'))){
    $where_str .= ' AND (pro.agent_id IN (SELECT agent_id FROM '.$agent_cls->getTable().' WHERE parent_id = '.$_SESSION['agent']['id'].')
                                OR IF(ISNULL(pro.agent_manager)
                                      OR pro.agent_manager = 0
                                      OR (SELECT parent_id FROM '.$agent_cls->getTable().' WHERE agent_id = '.$_SESSION['agent']['id'].') = 0
                                      ,pro.agent_id = '.$_SESSION['agent']['id'].'
                                      , pro.agent_manager = '.$_SESSION['agent']['id'].'))';
}else{
    $where_str = ' AND pro.agent_id = '.$_SESSION['agent']['id'];
}
if($action == 'view-dashboard'){
    $where_str = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `' . $bid_cls->getTable('bids_first_payment') . '` AS b WHERE b.agent_id = \'' . $_SESSION['agent']['id'] . '\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';
    $where_str .= '     OR (pro.property_id IN (SELECT DISTINCT bid.property_id
                                              FROM ' . $bid_cls->getTable() . ' AS bid
                                              WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' )
                        )';
    $property_data = Property_getList($where_str, 1, 5, '','',true);
}else{
    $property_data = Property_getList($where_str, $p, $len, '','',true);
}

$smarty->assign('property_data', $property_data);