<?php
class Facebook_detail extends Model{

	public function __construct(){
		parent::__construct();
		$this->table = 'fb_detail';
		$this->id = 'id';
		$this->fields = array('access_token' => '',
							  'email_address' => '',
                              'uid'=>'',
                              'agent_id'=>'',
                              'active'=>0
        );

    }
}
if (!isset($fb_detail_cls) || !($fb_detail_cls instanceof Facebook_detail)) {
	$fb_detail_cls = new Facebook_detail();
}
function FD_getInfo($email_address){
    global $fb_detail_cls;
    if ($email_address != ''){
        $row = $fb_detail_cls->getRow('email_address =\''.$email_address.'\'');
        if (is_array($row) and count($row)> 0){
            return $row;
        }
    }
    return null;
}

function FD_getInfoID($agent_id){
    global $fb_detail_cls;
    if ($agent_id > 0){
        $row = array();
        $row = $fb_detail_cls->getRow('agent_id =\''.$agent_id.'\'');
        if (is_array($row) and count($row)> 0){
            /*$data = array('token'=>$row['token'],
                          'token_sec'=>$row['token_secret']);*/
            return $row;
        }
    }
    return null;
}
function FD_hasID($email_address){
    global $fb_detail_cls;
    $row = array();
    $row = $fb_detail_cls->getRow('email_address =\''.$email_address.'\'');
    if (is_array($row) and count($row)> 0){
       return true;
    }
    return false;
}

function FD_getListFace($agent_id){
    global $fb_detail_cls;
    $options = array();
    $row = $fb_detail_cls->getRow('agent_id ='.$agent_id);
    if (is_array($row) and count($row)> 0){
      return $row;
    }
    return null;
}
?>