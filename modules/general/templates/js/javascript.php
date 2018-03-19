<?php

header("Content-type: text/javascript; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 24 * 7;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);

if (isset($_SERVER["DOCUMENT_ROOT"]) OR $_SERVER["DOCUMENT_ROOT"] != '') {
	define('ROOTPATH',$_SERVER["DOCUMENT_ROOT"]);
} else {
	define('ROOTPATH','/var/www/ibbnew/public_html');
}

ob_start("compress");


/* Begin function compress */
function compress($buffer) {
   # strip blank lines (blank, with tab or whitespaces)
   $buffer = preg_replace("/[\r\n]+[\s\t]*[\r\n]+/","\n",$buffer);
   # join lines
   $buffer = str_replace("[\r\n]", ' ', $buffer);
   # strip whitespace between > and <
   return preg_replace('/\>[\s\t]+\</', '> <', $buffer);
    /* remove unnecessary spaces */
    $buffer = str_replace('{ ', '{', $buffer);
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
	return $buffer;
}

require ROOTPATH.'/includes/functions.php';

$mobileBrowser = detectBrowserMobile();
if (!$mobileBrowser){
    require_once ROOTPATH.'/modules/general/templates/js/jquery-1.8.3.js';
    require_once ROOTPATH.'/modules/general/templates/js/jquery.tipsy.js';
}else{
    require_once ROOTPATH.'/modules/general/templates/js/jquery-1.8.3.js';
}


require_once ROOTPATH.'/modules/general/templates/mobile/js/check_mobile.js';
require_once ROOTPATH.'/modules/general/templates/js/cufon/cufon-yui.js';
require_once ROOTPATH.'/modules/general/templates/js/cufon/Neutra_Text_500-Neutra_Text_700.font.js';
require_once ROOTPATH.'/modules/general/templates/js/cufon/gos-api.js';
require_once ROOTPATH.'/modules/general/templates/js/gos_api.js';

require_once ROOTPATH.'/modules/general/templates/js/jquery.uniform.min.js';
require_once ROOTPATH.'/modules/general/templates/js/helper.js';
require_once ROOTPATH.'/modules/general/templates/js/common.js';

if (file_exists(ROOTPATH.'/APE/Clients/JavaScript.js')) 
	include_once ROOTPATH.'/APE/Clients/JavaScript.js';
if (file_exists(ROOTPATH.'/APE/Demos/config.js')) 
	include_once ROOTPATH.'/APE/Demos/config.js';

require_once ROOTPATH.'/modules/general/templates/js/frontend.js';
require_once ROOTPATH.'/modules/general/templates/js/jquery.tinyscrollbar.min.js';
require_once ROOTPATH.'/modules/general/templates/js/validate.js';
require_once ROOTPATH.'/modules/general/templates/js/confirmEmail.js';
require_once ROOTPATH.'/modules/calendar/templates/js/calendar.popup.js';
require_once ROOTPATH.'/modules/general/templates/shadowbox/shadowbox.js';
require_once ROOTPATH."/modules/general/templates/js/tab/jquery-ui-personalized-1.6rc6.min.js";
echo "\n";


ob_end_flush();

?>
