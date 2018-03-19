<?php
    include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
    include_once 'inc/systemlog.php';

    $day_clear = $config_cls->getKey('save_log_day');
    $auto_clear = $config_cls->getKey('auto_clear');
    if ($auto_clear == 'Yes'){
       $systemlog_cls->delete("datediff('".date('Y-m-d')."',Updated) > ".$day_clear);
    }


?>
