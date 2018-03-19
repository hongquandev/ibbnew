<?php

header("Content-Type: application/xml; charset=utf-8");
require '../../configs/config.inc.php';
require '../../includes/smarty/Smarty.class.php';
require_once  '../../includes/functions.php';
$smarty = new Smarty;
if (detectBrowserMobile()) {
    $smarty->compile_dir = '../../m.templates_c/';
} else {
    $smarty->compile_dir = '../../templates_c/';
}

if ($_SESSION['language'] == 'vn') {
    include 'lang/users.vn.lang.php';
} else {
    include 'lang/users.en.lang.php';
}



if ($_POST)
    $request = $_POST;
else if ($_GET)
    $request = $_GET;
else {
    echo '<error>no query</error>';
    return;
}

if ($request['ID'] > 0) {

    if ($request['Password'] != '') {
        $Password = md5($request['Password']);
        $sqlAdd = ", `Password`='$Password'";
    }

    if (!mysql_query("UPDATE `users` SET `FirstName`='{$request['FirstName']}', `LastName`='{$request['LastName']}', `EmailAddress`='{$request['EmailAddress']}', `Telephone`='{$request['Telephone']}', `Level`='{$request['userLevel']}' $sqlAdd WHERE `ID` = '{$request['ID']}'")) {


        echo "<error>{$usersLang['Duplicate']} </error>";
        return;
    }
    // Write System Logs

    mysql_query("INSERT INTO `systemlogs` SET  `Updated`='" . date("Y-m-d H:i:s") . "', `Action`='UPDATE', `Detail`='USERS WHERE ID: {$request['ID']}   SET FIRST NAME : {$request['FirstName']} SET LAST NAME: {$request['LastName']} SET EMAIL ADDRESS : {$request['EmailAddress']}  SET TELEPHONE : {$request['Telephone']} SET LEVEL : {$request['userLevel']}' , `UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '" . $_SERVER['REMOTE_ADDR'] . "'");
} else {
    $Password = md5($request['Password']);
    if (!mysql_query("INSERT INTO `users` SET `FirstName`='{$request['FirstName']}', `LastName`='{$request['LastName']}', `EmailAddress`='{$request['EmailAddress']}', `Telephone`='{$request['Telephone']}', `Password`='$Password', `Status` = 1, `Level`='{$request['userLevel']}'")) {

        echo "<error>{$usersLang['Duplicate']}</error>";
        return;
    }

    // Write System Logs

    mysql_query("INSERT INTO `systemlogs` SET  `Updated`='" . date("Y-m-d H:i:s") . "', `Action`='INSERT', `Detail`='USERS  SET FIRST NAME : {$request['FirstName']} SET LAST NAME: {$request['LastName']} SET EMAIL ADDRESS : {$request['EmailAddress']}  SET TELEPHONE : {$request['Telephone']} SET LEVEL : {$request['userLevel']}' , `UserID`='{$_SESSION['Admin']['EmailAddress']}', `IPAddress` = '" . $_SERVER['REMOTE_ADDR'] . "'");
}

echo "<error>{$usersLang['Updated']} {$request['Level']}</error>";
?>