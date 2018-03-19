<?php
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/note/inc/note.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/general/inc/bids_first.class.php';
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
    $bids_first_cls = new Bids_first();
}
global $config_cls;
switch ($action_ar[0]) {
    case 'delete':
        $id = (int)restrictArgs(getParam('id', 0));//product id
        //$mode = getParam('mode') == 'grid' ? getParam('mode') : 'list';
        $mode = getParam('mode');
        if ($id > 0 && $_SESSION['agent']['id'] > 0) {
            $row = $watchlist_cls->getRow('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($row) && count($row) > 0) {
                $watchlist_cls->delete('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' from your watchlist.');
            }
        }
        $link = ($mode == '') ? '/?module=agent&action=view-watchlist' : '/?module=agent&action=view-watchlist&mode=grid';
        redirect(ROOTURL . $link);

        break;
    default:
        // LIST
        $mode = getParam('mode') == 'grid' ? getParam('mode') : 'list';;
        $smarty->assign('mode', $mode);

        $title_bar = 'MY WATCHLIST';
        $smarty->assign('property_title_bar', $title_bar);

        $form_action = array('module' => 'agent', 'action' => 'view-watchlist');
        $form_data['mode'] = $mode;
        $form_action = '?' . http_build_query($form_action);
        $smarty->assign('form_action', $form_action);

        $smarty->assign('agent_id', $_SESSION['agent']['id']);
        $smarty->assign('agent_info', $_SESSION['agent']);

        $smarty->assign('pag_link', $form_action.'');
        $smarty->assign('pag_link_list', $form_action.'&mode=list');
        $smarty->assign('pag_link_grid', $form_action.'&mode=grid');
        if (getPost('len',0) > 0) {
            $_SESSION['len'] = (int)restrictArgs(getPost('len'));
        }
        $len = !empty($_SESSION['len']) ? $_SESSION['len'] : 9;
        $smarty->assign('ROOTURL', ROOTURL);
        $smarty->assign('len', $len);
        $smarty->assign('len_ar', PE_getItemPerPage());

        $p = (int)restrictArgs(getQuery('p',0));
        $p = $p <= 0 ? 1 : $p;
        $where_str = ' AND (  ( pro.property_id IN (SELECT DISTINCT wl.property_id
                                      FROM '.$watchlist_cls->getTable().' AS wl
                                      WHERE wl.agent_id = '.$_SESSION['agent']['id'].' )
                             ))';

        $property_data = Property_getList($where_str, $p, $len,'');
        $smarty->assign('property_data', $property_data);
        break;
}
?>