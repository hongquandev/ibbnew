<?php
if (isSubmit()) {
	$message = configPostDefault();
}

$form_action = '?module=configuration&action='.$action.'&token='.$token;

?>
