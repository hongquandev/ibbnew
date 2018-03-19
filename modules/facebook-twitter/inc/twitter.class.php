<?php
require_once ROOTPATH.'/modules/facebook-twitter/inc/OAuth.php';
require_once ROOTPATH.'/configs/config.inc.php';
require_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/fb.fb_detail.class.php';
include_once ROOTPATH.'/modules/facebook-twitter/inc/twitter_detail.class.php';
class Twitter{

  /* Contains the last HTTP status code returned. */
  public $http_code;
  /* Contains the last API call. */
  public $url;
  /* Set up the API root URL. */
  public $host = "https://api.twitter.com/1.1/";
  /* Set timeout default. */
  public $timeout = 30;
  /* Set connect timeout. */
  public $connecttimeout = 30;
  /* Verify SSL Cert. */
  public $ssl_verifypeer = FALSE;
  /* Respons format. */
  public $format = 'json';
  /* Decode returned json data. */
  public $decode_json = TRUE;
  /* Contains the last HTTP headers returned. */
  public $http_info;
  /* Set the useragnet. */
  public $useragent = 'TwitterOAuth v0.2.0-beta2';
  /* Immediately retry the API call if the response was not successful. */
  //public $retry = TRUE;




  /**
   * Set API URLS
   */
  function accessTokenURL()  { return 'https://api.twitter.com/oauth/access_token'; }
  function authenticateURL() { return 'https://api.twitter.com/oauth/authenticate'; }
  function authorizeURL()    { return 'https://api.twitter.com/oauth/authorize'; }
  function requestTokenURL() { return 'https://api.twitter.com/oauth/request_token'; }

  /**
   * Debug helpers
   */
  function lastStatusCode() { return $this->http_status; }
  function lastAPICall() { return $this->last_api_call; }

  /**
   * construct TwitterOAuth object
   */
  function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {
    $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
    if (!empty($oauth_token) && !empty($oauth_token_secret)) {
      $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
    } else {
      $this->token = NULL;
    }
  }

  function setToken($oauth_token = NULL, $oauth_token_secret = NULL){
     if (!empty($oauth_token) && !empty($oauth_token_secret)) {
         $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
     } else {
         $this->token = NULL;
     }
  }


  /**
   * Get a request_token from Twitter
   *
   * @returns a key/value array containing oauth_token and oauth_token_secret
   */
  function getRequestToken($oauth_callback = NULL) {
    $parameters = array();
    if (!empty($oauth_callback)) {
      $parameters['oauth_callback'] = $oauth_callback;
    }
    $request = $this->oAuthRequest($this->requestTokenURL(), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * Get the authorize URL
   *
   * @returns a string
   */
  function getAuthorizeURL($token, $sign_in_with_twitter = TRUE) {
    if (is_array($token)) {
      $token = $token['oauth_token'];
    }

    if (empty($sign_in_with_twitter)) {
      return $this->authorizeURL() . "?oauth_token={$token}";
    } else {
       return $this->authenticateURL() . "?oauth_token={$token}";
    }
  }

  /**
   * Exchange request token and secret for an access token and
   * secret, to sign API calls.
   *
   * @returns array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham")
   */
  function getAccessToken($oauth_verifier = FALSE) {
    $parameters = array();
    if (!empty($oauth_verifier)) {
      $parameters['oauth_verifier'] = $oauth_verifier;
    }
    $request = $this->oAuthRequest($this->accessTokenURL(), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * One time exchange of username and password for access token and secret.
   *
   * @returns array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham",
   *                "x_auth_expires" => "0")
   */
  function getXAuthToken($username, $password) {
    $parameters = array();
    $parameters['x_auth_username'] = $username;
    $parameters['x_auth_password'] = $password;
    $parameters['x_auth_mode'] = 'client_auth';
    $request = $this->oAuthRequest($this->accessTokenURL(), 'POST', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * GET wrapper for oAuthRequest.
   */
  function get($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'GET', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }

  /**
   * POST wrapper for oAuthRequest.
   */
  function post($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'POST', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }

  /**
   * DELETE wrapper for oAuthReqeust.
   */
  function delete($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'DELETE', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }

  /**
   * Format and sign an OAuth / API request
   */
  function oAuthRequest($url, $method, $parameters) {
    if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
      $url = "{$this->host}{$url}.{$this->format}";
    }
    $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);
    $request->sign_request($this->sha1_method, $this->consumer, $this->token);
    switch ($method) {
    case 'GET':
      return $this->http($request->to_url(), 'GET');
    default:
      return $this->http($request->get_normalized_http_url(), $method, $request->to_postdata());
    }
  }

  /**
   * Make an HTTP request
   *
   * @return API results
   */
  function http($url, $method, $postfields = NULL) {
    $this->http_info = array();
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
    curl_setopt($ci, CURLOPT_HEADER, FALSE);

    switch ($method) {
      case 'POST':
        curl_setopt($ci, CURLOPT_POST, TRUE);
        if (!empty($postfields)) {
          curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        break;
      case 'DELETE':
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if (!empty($postfields)) {
          $url = "{$url}?{$postfields}";
        }
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    $response = curl_exec($ci);
    $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
    $this->url = $url;
    curl_close ($ci);
    return $response;
  }

  /**
   * Get the header info to store.
   */
  function getHeader($ch, $header) {
    $i = strpos($header, ':');
    if (!empty($i)) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->http_header[$key] = $value;
    }
    return strlen($header);
  }

  public function getUser($info,$token){
      global $agent_cls,$twitter_detail_cls;
      try{
          if (!$info->id){
              die("<script >alert('Wrong API. Please waiting for we fix it. Thanks you!');window.opener.location.reload();window.close();window.focus();</script>");
          }
          if (!isset($_SESSION['agent']) || $_SESSION['agent']['id'] <= 0){
              $_SESSION['tw_info'] = $token;

              if (AT_hasID($info->id,'tw')){
              }else{
                  $type = AgentType_getArr();
                  $data = array('firstname'=>$info->name,
                                'provider_id'=>'tw-'.$info->id,
                                'type_id'=>$type['buyer'],
                                'is_active'=>1,
                                'ip_address' => $_SERVER['REMOTE_ADDR'],
                                'allow_twitter'=>1);
                  $agent_cls->insert($data);
              }
              if (TD_hasID('tw-'.$info->id)){
                  $twitter_detail_cls->update(array('token'=>$token['token'],
                                                    'token_secret'=>$token['token_sec'],
                                                    'username'=>$info->screen_name),
                                              'agent_id =\''.'tw-'.$info->id.'\'');
              }else{
                  $twitter_detail_cls->insert(array('agent_id'=>'tw-'.$info->id,
                                                    'token'=>$token['token'],
                                                    'token_secret'=>$token['token_sec'],
                                                    'username'=>$info->screen_name,
                                                    'creation_time'=>date('Y-m-d H:i:s')));
              }
              $row = $agent_cls->getRow('provider_id = \'tw-' . $info->id . '\'');
              if (is_array($row) and count($row) > 0) {
                  $type_row = $agent_cls->getRow("SELECT * FROM " . $agent_cls->getTable('agent_type') . " WHERE agent_type_id = " . $row['type_id'], true);
                  $type = 'buyer';
                  if ($row['is_active'] == 0) {
                      msg_alert('Your account active yet.', ROOTURL);
                  } elseif (is_array($type_row) and count($type_row) > 0) {
                      $type = $type_row['title'];
                      if (!$type_row['active']) {
                          die("<script>alert('Sorry, your account is disabled.');window.opener.location.reload();window.close();window.focus();</script>");
                      }
                  }
                  $_SESSION['agent'] = array('id' => $row['agent_id'],
                                             'full_name' => strlen($row['firstname'] . ' ' . $row['lastname']) > 300
                                                     ? safecontent($row['firstname'] . ' ' . $row['lastname'], 300) . '...'
                                                     : $row['firstname'] . ' ' . $row['lastname'],
                                             'firstname' => $row['firstname'],
                                             'lastname' => $row['lastname'],
                                             'email_address' => $row['email_address'],
                                             'auction_step' => $row['auction_step'],
                                             'maximum_bid' => $row['maximum_bid'],
                                             'type' => $type,
                                             'type_id' => $row['type_id'],
                                             'login' => true);


                  $_SESSION['fb_info'] = FD_getInfoID($_SESSION['agent']['id']);
              }
              //die("<script >window.opener.location.reload();window.close();window.focus();</script>");
              die("<script>window.opener.location.reload();window.close();window.focus();</script>");

          }else{
              $this->addUser($info,$token);
          }
      }catch (Exception $e){
          die("<script >alert('Process fail ! Please try again later.');window.opener.location.reload();window.close();window.focus();</script>");
      }
  }

  function addUser($info,$token){
     global $agent_cls,$twitter_detail_cls;
     $data = array('token'=>$token['token'],
                   'token_secret'=>$token['token_sec'],
                   'username'=>$info->screen_name,
                   'agent_id'=>'tw-'.$info->id);
     if(!TD_agentHasTwID($data['agent_id'])){//hadn't account
        if (TD_hasID($data['agent_id'])){
        }else{
            $twitter_detail_cls->insert($data);
        }
        $agent_cls->update(array('provider_id'=>'tw-'.$info->id),'agent_id = '.$_SESSION['agent']['id']);
        $_SESSION['tw_info'] = $token;
        die("<script >window.opener.location.reload();window.close();window.focus();</script>");
     }else{
        //msg_alert('Account "'.$data['username'].'" has been add to another iBB account. Please choose another account !',ROOTURL.'/?module=agent&action=view-dashboard');
        die("<script >alert('Account ".$data['username']." has been add to another iBB account. Please choose another account !');window.opener.location.reload();window.close();window.focus();</script>");
     }

  }

  public function tweet($text){
       if (isset($_SESSION['tw_info'])){
          $this->setToken($_SESSION['tw_info']['token'], $_SESSION['tw_info']['token_sec']);
          $status = $this->post_statusesUpdate(array('status' => $text));
          $status->response;
       }
  }
  public function logout(){
      unset($_SESSION['tw_info']);
      unset($_COOKIE['login_twitter']);

  }
}
?>
