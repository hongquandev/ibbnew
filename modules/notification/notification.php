<?php
include_once 'notification_app.class.php';

if (!isset($notification_app_cls) || !($notification_app_cls instanceof Notification_app)) {
    $notification_app_cls = new Notification_app();
}

/**
 * Created by JetBrains PhpStorm.
 * User: dbthai1978
 * Date: 12/11/12
 * Time: 6:53 PM
 * To change this template use File | Settings | File Templates.
 */

function doSave($issuer_id, $reg_id, $type)
{
    global $notification_app_cls;
    $notification_app_cls->doSave($issuer_id, $reg_id, $type);
}

/**
 * @param int $issuer_id
 * @param array $data
 * @return void
 *
 * data = array('type_msg'=>'update-list-property'): reload pro list
 */
function push($issuer_id = 0, $data = array())
{
    global $notification_app_cls;
    $reg_ids = $notification_app_cls->getRegIDs($issuer_id, Notification_app::ANDROID);
    if ($reg_ids != null && count($reg_ids) > 0) {
        $data['issuer_id'] = '';
        pushAndroid($reg_ids, $data);
    }
    
    $reg_ids1 = $notification_app_cls->getRegIDs($issuer_id, Notification_app::IPHONE);
    if ($reg_ids1 != null && count($reg_ids1) > 0) {
        $data['issuer_id'] = $issuer_id>0?$issuer_id:$_SESSION['agent']['id'];
        //pushIPhone($reg_ids1, $data);
        pushIPhoneRelease($reg_ids1, $data);
    }
}

function pushWithoutUserId($issuer_id = 0, $data = array())
{
    global $notification_app_cls;
    $reg_ids = $notification_app_cls->getRegIDsWithoutUserId($issuer_id, Notification_app::ANDROID);
    if ($reg_ids != null && count($reg_ids) > 0) {
        $data['issuer_id'] = $issuer_id>0?$issuer_id:$_SESSION['agent']['id'];
        pushAndroid($reg_ids, $data);
    }

    $reg_ids1 = $notification_app_cls->getRegIDsWithoutUserId($issuer_id, Notification_app::IPHONE);
    if ($reg_ids1 != null && count($reg_ids1) > 0) {
        $data['issuer_id'] = $issuer_id>0?$issuer_id:$_SESSION['agent']['id'];
        //pushIPhone($reg_ids1, $data);
        pushIPhoneRelease($reg_ids1, $data);
    }
}

function delete($issuer_id, $type)
{
    global $notification_app_cls;
    $notification_app_cls->delete("issuer_id='" . $issuer_id . "' AND type='" . $type . "'");
}

function pushAndroid($registrationIDs = array(), $data = array())
{
    if ($registrationIDs == null || count($registrationIDs) == 0) {
        return;
    }
    if ($data == null || count($data) == 0) {
        return;
    }
    try {
        $apiKey = 'AIzaSyCB1Fuf5EF6-d9r1VKyPXMK3mLXriAi-r0'; //Loader::getConfigByKeyword('android_notification_server_id');
        if ($apiKey == null || !isset($apiKey) || count($apiKey) == 0) {
            return;
        }
        // Replace with real client registration IDs
        //Get registration ID by user_id (receiver)
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registrationIDs,
            'data' => $data,
        );

        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        $response_info = curl_getinfo($ch);
        curl_close($ch);
    } catch (Exception $e) {

    }
}

    //====================================================
    //======== Function for run debug ====================
    //====================================================
    function pushIPhone($registrationIDs = array(), $data = array())
    {
        if ($registrationIDs == null || count($registrationIDs) == 0) {
            return;
        }
        if ($data == null || count($data) == 0) {
            return;
        }
        
        $passphrase = 'a054873245';
        $ctx = stream_context_create();
        
        stream_context_set_option($ctx, 'ssl', 'local_cert', ROOTPATH . '/modules/notification/ckdevelopment.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
        //Open a connection to the APNS server
        $fpstream = stream_socket_client(
                                         'ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        
        // Encode the payload as JSON
        $payload = json_encode($data);
        foreach ($registrationIDs as $regId) {
            // Build the binary notification
            $deviceToken = utf8_encode($regId);
            $msg = chr (0) . chr (0) . chr (32) . pack ('H*', $deviceToken) . pack ('n', strlen ($payload)) . $payload;
            
            // Send it to the server
            $result = fwrite($fpstream, $msg, strlen($msg));
        }
        
        fclose($fpstream);
    }
    
    //====================================================
    //========== Function for release product ============
    //====================================================
    function pushIPhoneRelease($registrationIDs = array(), $data = array())
    {
        if ($registrationIDs == null || count($registrationIDs) == 0) {
            return;
        }
        if ($data == null || count($data) == 0) {
            return;
        }
        
        $passphrase = 'luongpp2509';
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', ROOTPATH . '/modules/notification/MyPushRelease.pem');
        
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $fpstream = stream_socket_client(
                                         'ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        
        // Encode the payload as JSON
        $payload = json_encode($data);
        foreach ($registrationIDs as $regId) {
            // Build the binary notification
            $deviceToken = utf8_encode($regId);
            //$deviceToken = 'ae0fe0bf9553e21f3dc8d99f03f345b5cc409d486ecebd52dee78f9648ae3261';
            $msg = chr (0) . chr (0) . chr (32) . pack ('H*', $deviceToken) . pack ('n', strlen ($payload)) . $payload;
            
            // Send it to the server
            $result = fwrite($fpstream, $msg, strlen($msg));
        }
        
        fclose($fpstream); 
    }

?>