<?php
function propertyUploadMedia($path, $fileName) {
	createFolder($path.'/thumbs', 1);
	createThumbs2($fileName, 'overlay_'.$fileName, $path, $path);
	createImage($path.'/'.$fileName, $path.'/crop_'.$fileName);
    
    createThumbsCrop($fileName, $path, $path.'/thumbs', 300, 182);
	resizeImage(rtrim($path, '/') . '/' . $fileName, 617, 375);

}

function propertyDeleteMedia($path, $fileName) {
	if (is_link($path.'/'.$fileName)) @unlink($path.'/'.$fileName);
	if (is_link($path.'/thumbs/'.$fileName)) @unlink($path.'/thumbs/'.$fileName);
	if (is_link($path.'/crop_'.$fileName)) @unlink($path.'/crop_'.$fileName);
	if (is_link($path.'/overlay_'.$fileName)) @unlink($path.'/overlay_'.$fileName);
}

function propertyDeleteDoc($path, $fileName) {
	$file = $path.'/'.$fileName;
	if (is_file($file)) {
		@unlink($file);
	}
}

?>