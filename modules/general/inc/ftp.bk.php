<?php
//include_once $_SERVER['DOCUMENT_ROOT'].'/includes/ftp.class.php';
include_once ROOTPATH.'/modules/general/inc/ftp.class.php';
$ftp_cls = new Ftp(array('ftp_server' => $config_cls->getKey('mediaserver_host'),
                        'ftp_user' => $config_cls->getKey('mediaserver_user'),
                        'ftp_pass' => $config_cls->getKey('mediaserver_pass'),
                        'path'=>$config_cls->getKey('mediaserver_path')));
$_ftpPath = $config_cls->getKey('mediaserver_path');

function ftp_getPath($path) {
	global $_ftpPath;
    $ar = explode('store/uploads', $path);
	unset($ar[0]);
	if (preg_match('/ibb/', ROOTURL)) {
		return $_ftpPath.'/'.trim('store/uploads'.implode($ar),'/');
	} else {
		return $_SERVER['DOCUMENT_ROOT'].'/'.trim('store/uploads'.implode($ar),'/');
	}
}

function ftp_propertyUploadMedia($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->createFolders($ftp_path, 2);
	$ftp_cls->copyFile($path.'/'.$fileName, $ftp_path);
	$ftp_cls->copyFile($path.'/overlay_'.$fileName, $ftp_path);
	$ftp_cls->copyFile($path.'/crop_'.$fileName, $ftp_path);
	
	$ftp_cls->createFolders($ftp_path.'/thumbs', 1);
	$ftp_cls->copyFile($path.'/thumbs/'.$fileName, $ftp_path.'/thumbs');
}

function ftp_propertyDeleteMedia($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	if ($ftp_cls->isExist($ftp_path.'/'.$fileName)) $ftp_cls->deleteFile($ftp_path.'/'.$fileName);
	if ($ftp_cls->isExist($ftp_path.'/overlay_'.$fileName)) $ftp_cls->deleteFile($ftp_path.'/overlay_'.$fileName);
	if ($ftp_cls->isExist($ftp_path.'/crop_'.$fileName)) $ftp_cls->deleteFile($ftp_path.'/crop_'.$fileName);
	if ($ftp_cls->isExist($ftp_path.'/thumbs/'.$fileName)) $ftp_cls->deleteFile($ftp_path.'/thumbs/'.$fileName);
}

function ftp_propertyDelete($path) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->deleteFolder($ftp_path);
}

function ftp_propertyUploadDoc($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->createFolders($ftp_path, 1);
	$ftp_cls->copyFile($path.'/'.$fileName, $ftp_path);
}

function ftp_propertyDeleteDoc($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->deleteFile($ftp_path.'/'.$fileName);
}

function ftp_propertyDownDoc($from, $to) {
	global $ftp_cls;
	$from = ftp_getPath($from);
	//echo $from;
	//if ($ftp_cls->isExist($from)) {
		$ftp_cls->readFile($from, $to);
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($to));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($to));
		ob_clean();
		flush();
		readfile($to);
	//}
	
}

function ftp_mediaUpload($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->createFolders($ftp_path, 1);
	$ftp_cls->copyFile($path.'/'.$fileName, $ftp_path);
}

function ftp_mediaDelete($path, $fileName) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	if ($ftp_cls->isExist($ftp_path.'/'.$fileName)) {
		$ftp_cls->deleteFile($ftp_path.'/'.$fileName);
	}
}

function ftp_mediaRename($path, $oldFile, $newFile) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	$ftp_cls->renameFile($ftp_path, $oldFile, $newFile);
}

function ftp_mediaIsExist($path) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	if ($ftp_cls->isExist($ftp_path)) {
		return true;
	}
	return false;
}

function ftp_mediaList($path) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($path);
	return $ftp_cls->listFile($ftp_path);
}

function ftp_mediaFTP2Local($from, $to) {
	global $ftp_cls;
	$ftp_path = ftp_getPath($from);
	$ftp_cls->readFile($ftp_path, $to);
}

?>
