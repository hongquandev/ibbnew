<?
header("Content-type: text/javascript; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 24 * 7;
$ExpStr = "Expires: " . 
gmdate("D, d M Y H:i:s",
time() + $offset) . " GMT";
header($ExpStr);

if(isset($_SERVER["DOCUMENT_ROOT"]) OR $_SERVER["DOCUMENT_ROOT"] != '')
{
define('ROOTPATH',$_SERVER["DOCUMENT_ROOT"]);
}
else{
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
// base Javascript files
require_once ROOTPATH.'/modules/general/templates/js/fb-tw.js';
echo "\n";


ob_end_flush();

?>