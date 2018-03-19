<?php
$_SESSION['admin']['property']['path'] = ROOTPATH.'/store/uploads/'.$_SESSION['admin']['agent']['id'].'/'.$property_id.'/';

if (isSubmit()) {
	//redirect(ROOTURL.'?module='.$module.'&action=register&step='.($step+1));
    $property_document_uploaded = $property_document_cls->getRowsByDocumentIndex($property_id);
    $auctionSale = PE_getAuctionSaleProperty($property_id);
    $ok = true;
    $document_rows_require = DO_getRequireDocumentList($property_id);
    if (is_array($document_rows_require) and count($document_rows_require) > 0) {
        if (is_array($property_document_uploaded) && count($property_document_uploaded) > 0) {
            $i = 0;
            $count = count($document_rows_require);
            foreach ($property_document_uploaded as $document) {
                if (in_array($document['document_id'], $document_rows_require)) {
                    $i++;
                    $key = array_search($document['document_id'], $document_rows_require);
                    unset($document_rows_require[$key]);
                }
            }
            $ok = $count == $i ? true : false;
        } else {
            $ok = false;
        }
    }
    if ($ok) {
        redirect('/admin/?module=property&action=edit-rating&property_id='.$property_id.'&token='.$token);
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
$property_document_rows = $property_document_cls->getRowsByDocumentIndex($property_id);


$check = true;
$document_id_str = '';
//$document_id_str = PK_getAttribute('document_ids',$property_id);
$document_id_str = PA_getDocumentIds($property_id);
if ($document_id_str == 'all') {
	$check = false;
}
//print_r($document_id_str);
/*print_r_pre($_SESSION['property']);
print_r_pre('id='.$property_id);
print_r_pre($document_rows);
print_r_pre($document_id_str);*/
//NICE STRING
if (is_array($property_document_rows) and count($property_document_rows) > 0) {
	foreach ($property_document_rows as $key => &$row) {
		$row['file_name'] = basename($row['file_name']);
	}
}
$form_action = '/admin/?module=property&action=edit-document&property_id='.$property_id.'&token='.$token;

$smarty->assign('key',session_id());
$smarty->assign('document_rows',$document_rows);
$smarty->assign('property_document_rows',$property_document_rows);
$smarty->assign('check',$check);
$smarty->assign('document_id_ar',$document_id_str)
?>