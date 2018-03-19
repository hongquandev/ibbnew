<?php
//TEST
$step = (int)getParam('step',0);

if (isSubmit()) {
	$_SESSION['property']['step'] = $step;
	$track = (int)getPost('track');
    $property_document_uploaded = $property_document_cls->getRowsByDocumentIndex($_SESSION['property']['id']);
    $auctionSale = PE_getAuctionSaleProperty($_SESSION['property']['id']);
    $ok = true;
    $document_rows_require = DO_getRequireDocumentList($_SESSION['property']['id']);
    if (is_array($document_rows_require) and count($document_rows_require) > 0) {
        if (is_array($property_document_uploaded) && count($property_document_uploaded) > 0) {
            $i = 0;
            $count = count($document_rows_require);
            foreach ($property_document_uploaded as $document) {
                $doc_link = getParam('doc_link_'.$document['document_id'],'');
                if (in_array($document['document_id'], $document_rows_require) || !empty($doc_link)) {
                    $i++;
                    $key = array_search($document['document_id'], $document_rows_require);
                    unset($document_rows_require[$key]);
                }
            }
            //
            $ok = $count <= $i ? true : false;
        } else {
            $ok = false;
        }
    }
    if ($ok) {
        //Save documents link
        $document_rows = $document_cls->getRows('1 ORDER BY a.`order` ASC');
        foreach ($document_rows as $key => $row_doc) {
            $doc_link = getParam('doc_link_'.$row_doc['document_id'],'');
            if(empty($doc_link)){continue;}
            $row = $property_document_cls->getCRow(array('property_document_id'), 'property_id=' . $_SESSION['property']['id'] . ' AND document_id = ' . $row_doc['document_id']);
            if (is_array($row) && count($row) > 0) {
                $datas = array('link_name' => $doc_link,'active' => 1);
                $property_document_cls->update($datas, 'property_document_id=' . $row['property_document_id']);
            } else {
                $datas = array('property_id' =>  $_SESSION['property']['id'],
                    'document_id' => $row_doc['document_id'],
                    'link_name' => $doc_link,
                    'active' => 1);
                $property_document_cls->insert($datas);
            }
        }
        //
        if ($track == 1) {
           $message = 'Saved successfully.';
           $property_cls->update(array('step' => $step), 'property_id = ' . $_SESSION['property']['id']);
        } else {
           redirect(ROOTURL.'?module='.$module.'&action=register&step='.($step+1));
        }
    } else {
        $name = array();
        foreach ($document_rows_require as $id) {
            $info = DO_getDocumentInfo($id);
            $name[] = preg_replace('/upload/i', ' ', $info['title']);
        }
        $message = 'Please upload: ' . implode(', ', $name);
    }

}
$document_rows = $document_cls->getRows('1 ORDER BY a.`order` ASC');
$property_document_rows = $property_document_cls->getRowsByDocumentIndex($_SESSION['property']['id']);
$check = true;
//$document_id_str = PK_getAttribute('document_ids',$_SESSION['property']['id']);
$document_id_str = PA_getDocumentIds($_SESSION['property']['id']);
if(count($document_id_str) > 0 ){
}else{
    //Register property
}
/*if ($document_id_str == 'all') {
	$check = false;
}*/

//NICE STRING
if (is_array($property_document_rows) and count($property_document_rows) > 0) {
	foreach ($property_document_rows as $key => $row) {
		$property_document_rows[$key]['file_name'] = basename($row['file_name']);
		$property_document_rows[$key]['link_name'] = ($row['link_name']);
	}
}

//print_r($property_document_rows);
$doc_rows = array();
foreach ($property_document_rows as $key => $row) {
    $doc_rows['item_'.$row['document_id']] = $row;
}

//hide document
/*if ($document_id_str != 'all'){
    $document_id_ar = explode(',',$document_id_str);
    foreach ($document_rows as $k=>$document){
        if (!in_array($document['document_id'],$document_id_ar)){
            unset($document_rows[$k]);
        }
    }
}*/

if (is_array($document_id_str)){
    foreach ($document_rows as $k=>$row){
        if (!in_array($row['document_id'],$document_id_str)){
            unset($document_rows[$k]);
        }
    }
}


$smarty->assign(array('document_rows' => $document_rows,
				'property_document_rows' => $property_document_rows,
                'count_doc' => count($document_rows),
                'doc_rows' => $doc_rows,
				'document_id_ar' => $document_id_str,
				'check' => $check));
?>