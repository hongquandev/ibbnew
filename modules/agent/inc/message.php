<?php
include_once 'message.class.php';

if (!isset($message_cls) || !($message_cls instanceof Message)) {
    $message_cls = new Message();
}


function Mess_GetMaxOfferprice_By_id($property_id, $agent_id)
{
    global $message_cls, $row;
    if ($property_id > 0 and $agent_id > 0) {
        $row = $message_cls->getRow('SELECT  msg.entity_id,max(msg.offer_price) as max_price
                                           FROM ' . $message_cls->getTable() . ' AS msg
                                           WHERE msg.agent_id_from = ' . $agent_id . ' AND msg.entity_id = ' . $property_id . '
                                                 AND msg.abort = 0
                                           ', true);
        if (is_array($row) and count($row) > 0) {
            return $row['max_price'];
        }
    }
    return 0;
}

function Mess_GetField_By_maxprice($property_id, $agent_id, $max_price)
{
    global $message_cls, $row, $agent_cls;
    if ($property_id > 0 and $agent_id > 0 and $max_price > 0) {
        $row = $message_cls->getRow('SELECT  msg.*,agt.firstname, agt.lastname
                                           FROM ' . $message_cls->getTable() . ' AS msg,' . $agent_cls->getTable() . ' AS agt
                                           WHERE msg.agent_id_from = ' . $agent_id . ' AND msg.entity_id = ' . $property_id . '
                                                 AND msg.offer_price =' . $max_price . ' AND msg.abort = 0
                                           ORDER BY msg.send_date DESC
                                           ', true);
        if (is_array($row) and count($row) > 0) {
            return $row;
        }
    }
    return array();
}

function Mess_hasAcceptOffer($row = array()){
    global $message_cls, $agent_cls;
    if($row['agent_id_to'] > 0 && $row['agent_id_from'] > 0 && $row['entity_id'] > 0){
        $row = $message_cls->getRow('SELECT  msg.*,agt.firstname, agt.lastname
                                           FROM ' . $message_cls->getTable() . ' AS msg,' . $agent_cls->getTable() . ' AS agt
                                           WHERE msg.agent_id_from = ' .  $row['agent_id_from'] . '
                                                 AND msg.agent_id_to = ' .  $row['agent_id_to'] . '
                                                 AND msg.entity_id = ' .  $row['entity_id'] . '
                                                 AND msg.abort = 2
                                           ORDER BY msg.send_date DESC
                                           ', true);
        if (is_array($row) and count($row) > 0) {
            return true;
        }
    }
    return false;
}
?>