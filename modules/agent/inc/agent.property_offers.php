<?php
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
//ini_set('display_errors',1);
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
//ini_set('display_errors', 1);
$p = (int)restrictArgs(getQuery('p', 1));
$p = $p <= 0 ? 1 : $p;
$len = !empty($_GET['action']) && $_GET['action'] == 'export_csv_property_offers'? 1000: 5;
$action = getParam('action');
$offer_rows = $message_cls->getRows('SELECT SQL_CALC_FOUND_ROWS  msg.*
									    FROM ' . $message_cls->getTable() . ' AS msg
                                        WHERE  msg.entity_id > 0 AND msg.agent_id_to = "'.$_SESSION['agent']['id'].'"
                                        AND msg.offer_price IS NOT NULL
                                        ORDER BY msg.send_date DESC
                                        LIMIT ' . ($p - 1) * $len . ',' . $len, true);
$total_row = $message_cls->getFoundRows();
$datas = array();
$message = '';
if ($message_cls->hasError()) {
    $message = $message_cls->getError();
} else if (is_array($offer_rows) and count($offer_rows) > 0) {
    $i = $len * ($p - 1) + 1;
    foreach ($offer_rows as $key => $value) {

        //if(!empty($value['mess_id']) && $value['mess_id'] > 0) {
            //$row = $message_cls->getCRow(array(), 'message_id = ' . $value['mess_id'] . '');
            $row = $value;
            $agent_from = PE_getAgent($row['agent_id_from'], 0);
            //print_r($agent_from);
            $dt = new DateTime($row['send_date']);
            $datas[] = array(
                'status' => $row['abort'] == 1 ? 'Refuse' : ($row['abort'] == 2 ? 'Accepted' : 'Pending'),
                'offer_price' => showPrice($row['offer_price']),
                'property_details' => 'Property ID: '.$row['entity_id'].'<br />
                                       Address: '.PE_getAddressProperty($row['entity_id']).'<br />
                                       Offer Price: '.   showPrice($row['offer_price']).'<br />
                                       Message: '.  $row['user_content'],
                'time' => $dt->format($config_cls->getKey('general_date_format')) . ' ' . $dt->format('g.ia'),
                'ID' => $i++,
                'property_id' => $row['entity_id'],
                'message_id' => $row['message_id'],
                'link_detail' => PE_getUrl($row['entity_id']),
                'agent_from_name' => $agent_from['firstname'] . ' ' . $agent_from['lastname'],
                'agent_from_id' => $row['agent_id_from'],
                'agent_from_email_address' => $agent_from['email_address'],
                'agent_from_phone_number' => $agent_from['mobilephone'] .' | '. $agent_from['telephone'],
                'agent_from_term' => $bid_term_cls->getDataUserDetail($row['agent_id_from'],'short_name'),
                'checkAccepted' => Mess_hasAcceptOffer($row) ? 'disabled' : '',
                'address' => PE_getAddressProperty($row['entity_id']),
                'offer_price' => showPrice($row['offer_price']),
                'message' => $row['user_content']
            );
        //}
    }
    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
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
function __exportPropertyOffersCSV(){
    global $agent_cls, $datas;

    $content = array();
    try {
        $file_name = restrictArgs(getParam('file_name', ''), '[^0-9A-Za-z\-\_]');
        $file_name = $file_name == '' ? 'properties Offers '.date('Y-m-d H:i:s') : $file_name;
        header('Content-Type: text/octect-stream; charset=utf-8');
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Disposition: attachment; filename="' . $file_name . '.csv";');
        ob_clean();
        flush();
        /*---------------BEGIN CSV---------------*/
        $rows = $datas;
        if (count($rows) > 0 and is_array($rows)) {
            foreach ($rows as $key => $row) {
                /*---------------- CONTENT-----------------*/
                $content['No'][] = $key + 1;
                $content['Property ID'][$key] = $row['property_id'];
                $content['Agent'][$key] =
                    "Agent ID:".$row['agent_from_id'].'| '.
                    "Name:".$row['agent_from_name'].'| '.
                    "Email:".$row['agent_from_email_address'].'| '.
                    "Phone Number:".$row['agent_from_phone_number'].'| '
                ;
                $content['Address'][$key] = $row['address'];
                $content['Offer Price'][$key] = $row['offer_price'];
                $content['Message'][$key] = $row['message'];
                $content['Date of offer'][$key] = $row['time'];
                $content['Status'][$key] = $row['status'];
            }
            /* CSV SAVE CONTENT*/
            $title_ar = array_keys($content);
            echo '"' . stripslashes(implode('","', $title_ar)) . "\"\n";
            for ($i = 0; $i < count($rows); $i++) {
                $csv_property_data = array();
                foreach ($title_ar as $key_title) {
                    $csv_property_data[] = '"' . str_replace(array("\"", '"', "_"), array('', '""', ' '), $content[$key_title][$i]) . '"';
                }
                echo '' . stripslashes(implode(',', $csv_property_data)) . "\n";
            }
        }
        exit;
    } catch (Exception $er) {
        print_r($er->getMessage());
    }
}
?>