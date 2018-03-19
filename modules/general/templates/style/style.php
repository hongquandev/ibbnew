<?php
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 24 * 7;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
header($ExpStr);

if(isset($_SERVER["DOCUMENT_ROOT"]) OR $_SERVER["DOCUMENT_ROOT"] != '') {
	define('ROOTPATH',$_SERVER["DOCUMENT_ROOT"]);
} else {
	define('ROOTPATH','/var/www/bidRhino.com');
}

//ob_start ("ob_gzhandler");

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
    $buffer = str_replace(';', ';', $buffer);

return $buffer;
}

require_once("handler.php"); 
$userData = userInfo();
// Base css files
require_once('styles.css');
require_once ROOTPATH.'/utils/slide/style.css';
require_once ROOTPATH.'/modules/general/templates/shadowbox/shadowbox.css';
require_once ROOTPATH.'/modules/calendar/templates/style/calendar.css';

require_once('styles1.css');
require_once('font/helveticaneue-condensed.css');

echo "\n";

// BEGIN addons
// FOR Browser

if (isset($userData["user_agent_ie"]) && file_exists($userData["user_agent_ie"].'.css')) {
    echo "\n/* Included for ".$userData["user_agent_ie"]." */\n";
    include($userData["user_agent_ie"].'.css');
}

// platform

// For each browser
$filename = $userData["user_agent"].'.css';
if (file_exists($filename)) {
	echo "\n/* Included for ".$userData["user_agent"]." */\n";
	include($filename);
}
else{echo "\n/* NO EXTRA BROWSER CSS for ".$userData["user_agent"]." */\n";}

$filename = $userData["user_os"].'-'.$userData["user_agent"].'.css';
if (file_exists($filename)) {
	echo "\n/* Included for ".$userData["user_os"].'-'.$userData["user_agent"]." */\n";
	include($filename);
}
else{echo "\n/* NO EXTRA BROWSER CSS for ".$userData["user_os"].'-'.$userData["user_agent"]." */\n";}

ob_end_flush();
?>
#topnav a.signin,#topnav a.menu-open,#signin-top
    {
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
        behavior: url(/modules/general/templates/style/PIE.htc);
        position: relative;
    }
