<?php
if (!isset($_SESSION['admin'])) {
	$_SESSION['admin'] = array();
}

if (!isset($_SESSION['admin']['agent'])) {
	$_SESSION['admin']['agent'] = array();
}	

if (!isset($_SESSION['admin']['agent']['id'])) {
	$_SESSION['admin']['agent']['id'] = 0;
}

if (!isset($_SESSION['admin']['property'])) {
	$_SESSION['admin']['property'] = array();
}

if (!isset($_SESSION['admin']['property']['path'])) {
	$_SESSION['admin']['property']['path'] = '';
}


?>