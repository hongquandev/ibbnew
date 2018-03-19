<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
 include_once ROOTPATH.'/modules/general/inc/timetable.class.php';

    if (!isset($timetable_cls) || !($timetable_cls instanceof Timetable)) {
        $timetable_cls = new Timetable();
    }

if (isSubmit()) {
    $valid = false;
	// Add entime
    $date_time = array();
    $message = 'Updated fail.';
    if(is_array($_POST['fields_time']) and count($_POST['fields_time']) > 0)
    {
        foreach($_POST['fields_time'] as $key => $val)
        {
            if($key == 'endtime-enable')
            {
                $row = $config_cls->getRow("`key` = '".$key."'");
                if (is_array($row) && count($row) > 0) {// UPDATE
                    $config_cls->update(array('value' => $val),"`key` = '".$key."'");
                } else {// NEW
                    $config_cls->insert(array('key' => $key, 'value' => $val));
                    createConfigXml();
                }
                
                $key_name = 'server';
                $timetable_cls->update(array('begin_time' => date('Y-m-d H:i:s')),'`key`=\''.$key_name.'\'');

                if($val == 1)
                {
                    $message = 'Enable Successful.';
                }
                else
                    $message = 'Disable Successful.';
                //print_r($config_cls->sql);

            }
            else{
                if(is_numeric($val))
                {
                    $date_time[$key]= $val;
                    $valid = true;
                }
                else{
                     //print_r($val);
                    $valid = false;
                    break;
                }

            }
            
        }
        if($valid)
        {
            $sec = $date_time['days']*24*60*60 + $date_time['hrs']*60*60 + $date_time['min']*60 + $date_time['sec'];

            if($sec != 0 )
            {

                $auction_sale_ar = PEO_getAuctionSale();
                $auction_rows = $property_cls->getRows('SELECT  pro.property_id,
                                                        pro.end_time,
                                                        pro.start_time,
                                                        pro.pay_status,
                                                        pro.stop_bid,
                                                        pro.confirm_sold,
                                                        pro.auction_sale,
                                                        pro.active,
                                                        pro.agent_active

                                                    FROM '.$property_cls->getTable().' as pro

                                                    WHERE pro.auction_sale = '.$auction_sale_ar['auction'].'
                                                    AND pro.stop_bid = 0
                                                    AND pro.start_time != \'0000-00-00 00:00:00\'
                                                    AND pro.end_time != \'0000-00-00 00:00:00\'
                                                    AND pro.pay_status = '.Property::PAY_COMPLETE.'
                                                    AND pro.confirm_sold = '.Property::SOLD_UNKNOWN.'
                                                    AND pro.active = 1
                                                    AND pro.agent_active = 1
                                                    AND IF(pro.hide_for_live = 1 AND pro.start_time > \''.date('Y-m-d H:i:s').'\' , 0, 1) = 1
                                                    AND IF((SELECT IF (ISNULL(pro_term.value) OR pro_term.value = \'\',0,pro_term.value)
                                                                 FROM '.$property_cls->getTable('property_term').' AS pro_term
                                                                 LEFT JOIN '.$property_cls->getTable('auction_terms').' AS term
                                                                        ON pro_term.auction_term_id = term.auction_term_id
                                                                 WHERE term.code = \'auction_start_price\'
                                                                 AND pro.property_id = pro_term.property_id ) = 0, 0, 1) = 1
                                                    ORDER BY pro.property_id DESC
                                                                ',true);
                //die (print_r($property_cls->sql));
                //print_r('</br> Count='.count($auction_rows).'</br>');
                //die('Ok');
                if(is_array($auction_rows) and count($auction_rows) > 0 )
                {
                    foreach ($auction_rows  as $row)
                    {
                        $property_id = $row['property_id'];

                        if($row['start_time'] < date('Y-m-d H:i:s') and $row['end_time'] >  date('Y-m-d H:i:s') and !PE_isTheBlock($row['property_id']) ) //live
                        {
                            $dt = new DateTime($row['end_time']);
                            $key = 'end_time';
                            $new_time = date("Y-m-d H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') + $sec, $dt->format('m'), $dt->format('d'), $dt->format('Y')));
                            $property_cls->update(array('end_time' => $new_time),'property_id = '.$property_id);
                        }
                        if($row['start_time'] > date('Y-m-d H:i:s') and $row['end_time'] > date('Y-m-d H:i:s')) // Forth
                        {
                            $dt = new DateTime($row['start_time']);
                            $key = 'start_time';
                            $new_time = date("Y-m-d H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') + $sec, $dt->format('m'), $dt->format('d'), $dt->format('Y')));
                            $property_cls->update(array($key => $new_time),'property_id = '.$property_id);

                            if (!PE_isTheBlock($row['property_id'])){
                                $dt = new DateTime($row['end_time']);
                                $key = 'end_time';
                                $new_time = date("Y-m-d H:i:s", mktime($dt->format('H'), $dt->format('i'), $dt->format('s') + $sec, $dt->format('m'), $dt->format('d'), $dt->format('Y')));
                                $property_cls->update(array('end_time' => $new_time),'property_id = '.$property_id);
                            }
                        }
                    }
                    $message = 'Updated successful. You had added end time with  '.$date_time['days'].' days '.$date_time['hrs'].' hours '.$date_time['min'].' minutes '.$date_time['sec'].' seconds';

                }


            }
        }
        else
        {
            $message = ' The input information is not number.';
        }


    }

    if(is_array($_POST['fields']) and count($_POST['fields']) > 0 )
    {
        $message = configPostDefault();
    }

}
    $key = 'endtime-enable';
    $row = $config_cls->getRow("`key` = '".$key."'");
    if(count($row) > 0 and is_array($row))
    {
        $smarty->assign('endtime-enable',$row['value']);

    }



?>