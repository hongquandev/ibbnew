<?php
include_once ROOTPATH . '/modules/general/inc/development.class.php';
function _exportCSV_developments(){
    global $development_cls;
    $file_name = restrictArgs('developments_csv_export_'.date("Y-m-d"),'[^0-9A-Za-z\-\_]');
    $file_name = $file_name == '' ? 'data' : $file_name;
    header('Content-Type: text/octect-stream; charset=utf-8');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="'.$file_name.'.csv"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Disposition: attachment; filename="'.$file_name.'.csv";');
    ob_clean();
    flush();
    $title = $content = array();
    $title[0] = 'No';
    $title[1] = 'First Name';
    $title[2] = 'Last Name';
    $title[3] = 'Email_address';
    $title[4] = 'Post Code';
    $title[5] = 'What best describes you?';
    $title[6] = 'What are you interested in?';
    $title[7] = 'Are you interested in a project?';
    echo '"' . stripslashes(implode('","',$title)) . "\"\n";
    $rows = $development_cls->getRows('SELECT dev.*
							FROM '.$development_cls->getTable().' AS dev
							ORDER BY development_id' , true);
    $no = 0;
    if (is_array($rows) and count($rows) > 0) {
        foreach ($rows as $key => $row) {
            $no++; $row['development_id'] = $no;
            echo '"' . stripslashes(implode('","',$row)) . "\"\n";
        }
    }
    exit;
}

?>