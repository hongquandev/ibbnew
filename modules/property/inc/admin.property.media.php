<?php
if (isSubmit()) {
    redirect(ROOTURLS . '/admin/?module=' . $module . '&action=edit-document&property_id=' . $property_id . '&token=' . $token);
}
$photo_ar = PM_getPhoto($property_id, true);
$photo_rows = array();
$video_rows = array();
if (is_array($photo_ar['photo_thumb']) && count($photo_ar['photo_thumb']) > 0) {
    foreach ($photo_ar['photo_thumb'] as $key => $row) {
        ${'photo_rows'}[$key] = $row;
        ${'photo_rows'}[$key]['file_name'] = MEDIAURL . '/' . $row['file_name'];
        ${'photo_rows'}[$key]['action'] = '/modules/property/action.admin.php?action=delete-media&type=photo&property_id=' . $property_id . '&media_id=' . $row['media_id'] . '&token=' . $token;
    }
}
if ($config_cls->getKey('youtube_enable') == 1) {
    $video_ar = PM_getYT($property_id);
    if (is_array($video_ar['video']) && count($video_ar['video']) > 0) {
        foreach ($video_ar['video'] as $key => $row) {
            ${'video_rows'}[$key] = $row;
            ${'video_rows'}[$key]['file_name'] = $row['file_name'];
        }
    }
    $smarty->assign('is_yt', true);
} else {
    $smarty->assign('is_yt', false);
    $video_ar = PM_getVideo($property_id);
    if (is_array($video_ar['video']) && count($video_ar['video']) > 0) {
        foreach ($video_ar['video'] as $key => $row) {
            ${'video_rows'}[$key] = $row;
            ${'video_rows'}[$key]['file_name'] = '/' . $row['file_name'];
            ${'video_rows'}[$key]['action'] = '/modules/property/action.admin.php?action=delete-media&type=media&property_id=' . $property_id . '&media_id=' . $row['media_id'] . '&token=' . $token;
            ${'video_rows'}[$key]['ext'] = strtolower(end(explode(".", $row['file_name'])));
        }
    }
}
$photo_num = PK_getAttribute('photo_num', (int)@$property_id);
$form_action = ROOTURLS . '/admin/?module=property&action=edit-document&property_id=' . $property_id . '&token=' . $token;
$smarty->assign(array('photos' => $photo_rows,
    'videos' => $video_rows));
$smarty->assign('no_form', true);
$smarty->assign('max_allow', $photo_num == 'all' ? $photo_num : $photo_num - count($photo_rows));
$smarty->assign('is_ie', (int)isIE());
// new yt
$smarty->assign('is_ie', false);
$smarty->assign('is_yt', false);