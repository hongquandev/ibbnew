<?php
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/property/inc/property.php';

$p = (int)restrictArgs(getQuery('p', 1));
$p = $p <= 0 ? 1 : $p;
$len = 10;
$action = getParam('action');
$offer_rows = $message_cls->getRows('SELECT SQL_CALC_FOUND_ROWS distinct msg.*
									    FROM ' . $message_cls->getTable() . ' AS msg
                                        WHERE  msg.entity_id > 0 AND msg.agent_id_from = "'.$_SESSION['agent']['id'].'"
                                        ORDER BY msg.send_date DESC
                                        LIMIT ' . ($p - 1) * $len . ',' . $len, true);

$total_row = $message_cls->getFoundRows();
$datas = array();
$message = '';
if ($message_cls->hasError()) {
    $message = $message_cls->getError();
} else if (is_array($offer_rows) and count($offer_rows) > 0) {
    $i = $len * ($p - 1) + 1;
    foreach ($offer_rows as $key => $row) {
        $dt = new DateTime($row['send_date']);
        $datas[] = array(
            'status' => $row['abort'] == 1? 'Refuse' :(  $row['abort'] == 2 ? 'Accepted' : 'Pending'),
            'offer_price' => showPrice($row['offer_price']),
            'property_details' => 'Property ID: '.$row['entity_id'].'<br />
                                       Address: '.PE_getAddressProperty($row['entity_id']).'<br />
                                       Offer Price: '.   showPrice($row['offer_price']).'<br />
                                       Message: '.  $row['user_content'],
            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' at ' . $dt->format('H:m'),
            'ID' => $i++,
            'property_id' => $row['entity_id'],
            'link_detail' => PE_getUrl($row['entity_id'])
        );
    }
    $pag_cls->setTotal($total_row)
        ->setPerPage($len)
        ->setCurPage($p)
        ->setLenPage(10)
        ->setLayout('link_simple')
        ->setUrl('?module=agent&action='.$action)
    ;
    $smarty->assign('p', $p);
    $smarty->assign('len', $len);
    $smarty->assign('pag_str', $pag_cls->layout());
    $smarty->assign('rows', formUnescapes($datas));
}
$smarty->assign('message', $message);
?>