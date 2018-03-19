<?php

include_once ROOTPATH . '/modules/note/inc/note.php';
global $config_cls;
if (!($rating_cls) || !($rating_cls instanceof Ratings)) {
    $rating_cls = new Ratings();
}

if (!($bid_transition_history_cls) || !($bid_transition_history_cls instanceof bids_transition_history)) {
    $bid_transition_history_cls = new bids_transition_history();
}
if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
    $property_history_cls = new property_history();
}

$form_data = array();

switch ($action_ar[0]) {
    case 'delete':
        $id = (int)restrictArgs(getParam('id', 0));
        $mode = getParam('mode') == 'grid' ? 'grid' : 'list';
        $page = getParam('page', 'my-property-bids');
        if ($page == 'my-reg-to-bids') {
            if ($_SESSION['agent']['id'] > 0 and $id > 0) {
                $bid_first_cls->update(array('abort' => 1), 'property_id =' . $id . ' AND agent_id=' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property register to bid list.');
            }

        } elseif ($id > 0 && $_SESSION['agent']['id'] > 0) {
            $row = $bid_cls->getRow('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($row) && count($row) > 0) {
                $bid_cls->delete('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property bid list.');
            }
            $tran_row = $bid_transition_history_cls->getRow('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
            if (is_array($tran_row) and count($tran_row) > 0) {
                $bid_transition_history_cls->delete('property_id = ' . $id . ' AND agent_id = ' . $_SESSION['agent']['id']);
                $session_cls->setMessage('Delete #' . $id . ' in your property bid list.');
            }

        }
        $restrict_page = '&bids_filter=' . $page;
        $link = ($mode == 'list') ? '/?module=agent&action=view-property_bids' . $restrict_page : '/?module=agent&action=view-property_bids&mode=grid' . $restrict_page;
        redirect(ROOTURL . $link);

        break;
    default:
        // LIST
        $mode = getParam('mode') == 'grid' ? getParam('mode') : 'list';;
        $smarty->assign('mode', $mode);

        $title_bar = '<span style="font-size: 15px">MY PROPERTY BIDS/REGISTER TO BIDS</span> ';
        $smarty->assign('property_title_bar', $title_bar);

        $form_action = array('module' => 'agent', 'action' => 'view-property_bids');
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

        $where_str = ' AND (pro.property_id IN (SELECT DISTINCT b.property_id FROM `' . $bid_cls->getTable('bids_first_payment') . '` AS b WHERE b.agent_id = \'' . $_SESSION['agent']['id'] . '\' AND b.pay_bid_first_status > 0 AND b.abort = 0 ) ) ';
        $where_str .= ' OR (pro.property_id IN (SELECT DISTINCT bid.property_id
                                              FROM ' . $bid_cls->getTable() . ' AS bid
                                              WHERE bid.agent_id = ' . $_SESSION['agent']['id'] . ' ))';
        $property_data = Property_getList($where_str, $p, $len, '');
        $smarty->assign('property_data', $property_data);
        break;
}
?>