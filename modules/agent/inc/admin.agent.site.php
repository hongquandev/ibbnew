<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'partner.php';
include_once 'company.php';
include_once ROOTPATH.'/modules/theblock/inc/background.php';

//FOR PERSONAL SITE
$form_data = $agent_site_cls->getFields();

$row = $agent_site_cls->getRow('agent_id = ' . $agent_id.' AND type = \'agency\'');
if (is_array($row) and count($row)> 0){
    $form_data = $row;
}
$background = $background_cls->getFields();
$form_data = $form_data + $background;
$rows = $background_cls->getRows('agent_id = '.$agent_id);

if (is_array($rows) and count($rows)> 0){
    foreach ($rows as $row){
        if ($row['type'] == 'top'){
            $form_data['background_'.$row['type']] = MEDIAURL.'/store/uploads/background/img/'.$row['link'];
        }else{
            if ($row['link'] != ''){
                 $form_data['background_'.$row['type']] = MEDIAURL.'/store/uploads/background/thumbs/'.$row['link'];
            }
            $form_data['repeat'] = $row['repeat'];
            $form_data['fixed'] = $row['fixed'];
            $form_data['background_color'] = $row['background_color'];
        }
    }
}

//UPDATE INFORMATION
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = false;
    foreach ($form_data as $k=>$val){
        if(isset($_POST['fields'][$k])){
            $form_data[$k] = $data[$k] = $agent_site_cls->escape($_POST['fields'][$k]);
        }
    }

    $data['name'] = strtolower($data['name']);
    if (!$error) {
        if (!Agent_checkValidSite($data['name'],$form_data['site_id'],$message)){
            $error = true;
        }
    }
    $data['agent_id'] = $agent_id;
    $data['type'] = 'agency';
    $form_data['logo'] = $data['logo'] = $data['logo'][0];
    if (!$error){
        if ($data['name'] || $data['logo'] != '' || $data['background_logo'] != ''){
            if ($data['name'] == ''){unset($data['name']);}
            $check = Agent_checkExitsSite($agent_id,'agency');
            if ( $check > 0){
                $agent_site_cls->update($data,'site_id = '.$check);
            }else{
                $agent_site_cls->insert($data);
            }
        }
    }

    $save_data['background_color'] = $data['background_color'];
    $form_data['repeat'] = $save_data['repeat'] = isset($_POST['fields']['repeat']) ? 1 : 0;
    $form_data['fixed'] = $save_data['fixed'] = isset($_POST['fields']['fixed']) ? 1 : 0;
    if (isset($_SESSION['Admin']['bg']) and count($_SESSION['Admin']['bg']) > 0){
        foreach ($_SESSION['Admin']['bg'] as $k=>$val){
            $form_data['background_'.$k] = ($k == 'top')?MEDIAURL.'/store/uploads/background/img/'.$val:MEDIAURL.'/store/uploads/background/thumbs/'.$val;
            $row = $background_cls->getRow('agent_id = '.$agent_id." AND type = '{$k}'");
            $save_data['link'] = $val;
            $save_data['agent_id'] = $agent_id;
            $save_data['type'] = $k;
            if ($k == 'top'){
                $save_data['background_color'] = $data['background_logo'];
            }
            if (is_array($row) and count($row)> 0){
                $background_cls->update($save_data,"agent_id = {$agent_id} AND type = '{$k}'");
            }else{
                $save_data['upload-time'] = date('Y-m-d');
                $background_cls->insert($save_data);
            }
        }
    }else{
        $rows = $background_cls->getRows('agent_id = '.$agent_id." AND type != 'top'");
        if (is_array($rows) and count($rows) > 0){
            $background_cls->update($save_data,"agent_id = {$agent_id}");
        }else{
            $save_data['agent_id'] = $agent_id;
            $save_data['type'] = 'left';
            $background_cls->insert($save_data);
            $save_data['type'] = 'right';
            $background_cls->insert($save_data);;
        }
    }
}
unset($_SESSION['Admin']['bg']);
$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('description',$config_cls->getKey('description_site_agency'))
?>