<?php
include_once ROOTPATH . '/modules/general/inc/bids.php';
include_once ROOTPATH . '/modules/agent/inc/agent.php';
include_once ROOTPATH . '/modules/property/inc/property.php';
include_once ROOTPATH . '/modules/term/inc/bid_term.class.php';
//ini_set('display_errors',1);
if (!isset($bid_term_cls) || !($bid_term_cls instanceof Bids_term)) {
    $bid_term_cls = new Bids_term();
}
$p = (int)restrictArgs(getQuery('p', 1));
$p = $p <= 0 ? 1 : $p;
$len = !empty($_GET['action']) && $_GET['action'] == 'export_csv_property_offers'? 1000: 20;
$action = getParam('action');

$bid_rows = $payment_store_cls->getRows('  SELECT SQL_CALC_FOUND_ROWS
                                                     pay.property_id,
                                                     pay.agent_id,
                                                     pay.creation_time,
                                                     pay.is_paid,
                                                     pay.is_disable,
                                                     pay.allow,
                                                     agt.firstname,
                                                     agt.lastname,
                                                     agt.agent_id AS Agent_id,
                                                     agt.email_address,
                                                     agt.telephone,
                                                     agt.mobilephone,
                                                     (SELECT count(bid.agent_id)
                                                            FROM ' . $bid_cls->getTable() . ' AS bid
                                                            WHERE 1 AND bid.agent_id = pay.agent_id
                                                            ) AS bid_number
                                                     FROM ' . $payment_store_cls->getTable() . ' AS pay,' . $agent_cls->getTable() . ' AS agt
                                            WHERE   pay.agent_id = agt.agent_id
                                                    AND 1
                                                    AND pay.property_id IN (SELECT pro.property_id
                                                        FROM ' . $property_cls->getTable() . ' AS pro
                                                        WHERE (pro.agent_id = ' . $_SESSION['agent']['id'] . ' OR pro.agent_manager = ' . $_SESSION['agent']['id'] . ' )
                                                        )
                                                    AND (pay.bid = 1 OR pay.offer = 1)
                                                    AND pay.is_paid > 0

                                            ORDER BY pay.creation_time DESC
                                            LIMIT ' . ($p - 1) * $len . ',' . $len
    , true);
//print_r($payment_store_cls->sql);
$total_row = $payment_store_cls->getFoundRows();
$rows = array();
if ($payment_store_cls->hasError()) {
} else if (is_array($bid_rows) and count($bid_rows) > 0) {
    $i = $len * ($p - 1) + 1;
    foreach ($bid_rows as $key => $row) {
        //print_r($row);
        $dt = new DateTime($row['creation_time']);
        $row['fullname'] = $row['name'] = $row['firstname'] . ' ' . $row['lastname'];
        if (!$isAgent) {
            $row['name'] = getShortName($row['firstname'], $row['lastname']);
        }
        $status = $row['is_disable'] == 1 ? 'No' : 'Yes';
        $allow = $row['allow'] == 1 ? 'Yes' : 'No';
        $row['disable'] = '<a style="text-decoration: underline;" class="cancel-button" id="disable_' . $i . '" href="javascript:void(0)">' . $status . '</a>';
        $row['disable_label'] = $status;
        $row['allow_str'] = '<a style="text-decoration: underline;" class="cancel-button" id="allow_' . $i . '" href="javascript:void(0)">' . $allow . '</a>';
        $row['allow_label'] = $allow;
        $rows[] = array('name' => $row['name'],
            'email' => $row['email_address'],
            'agent_id' => $row['Agent_id'],
            'bidNumber' => $row['bid_number'],
            'time' => $dt->format($config_cls->getKey('general_date_format')) . ' ' . $dt->format('H:m'),
            'disable' => $row['disable'],
            'is_disable' => $row['is_disable'],
            'allow' => $row['allow'],
            'allow_str' => $row['allow_str'],
            'ID' => $i++,
            'property_id' => $row['property_id'],
            'dataTerm' => $bid_term_cls->getDataUserDetail($row['Agent_id'],'short_name'),
            'fullname' => $row['fullname'],
            'disable_label' => $row['disable_label'],
            'allow_label' => $row['allow_label'],
            'telephone' => $row['telephone'],
            'mobilephone' => $row['mobilephone']
        );
        //'time' => $row['bid_first_time']);
    }
    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
    }
    $pag_cls->setTotal($total_row)
        ->setPerPage($len)
        ->setCurPage($p)
        ->setLenPage(10)
        ->setLayout('simple_combobox')
        ->setUrl('?module=agent&action=' . $action);
    $smarty->assign('p', $p);
    $smarty->assign('len', $len);
    $smarty->assign('pag_str', $pag_cls->layout());
    $smarty->assign('rows', formUnescapes($rows));
}
function __exportRegisteredOffersCSV(){
    global $agent_cls, $rows;
    $content = array();
    try {
        $file_name = restrictArgs(getParam('file_name', ''), '[^0-9A-Za-z\-\_]');
        $file_name = $file_name == '' ? 'Registered Buyers '.date('Y-m-d H:i:s') : $file_name;
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
        if (count($rows) > 0 and is_array($rows)) {
            foreach ($rows as $key => $row) {
                /*---------------- CONTENT-----------------*/
                $content['No'][] = $key + 1;
                $content['Pro ID'][$key] = $row['property_id'];
                $content['Agent'][$key] =
                    "Agent ID:".$row['agent_id'].'| '.
                    "Fullname:".$row['fullname'].'| '.
                    "Phone Number:".$row['mobilephone'].' | '.$row['telephone'] .'| '
                ;
                $content['Email'][$key] = $row['email'];
                $content['Register time'][$key] = $row['time'];
                $content['Allow'][$key] = $row['allow_label'];
                $content['Enable'][$key] = $row['disable_label'];
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