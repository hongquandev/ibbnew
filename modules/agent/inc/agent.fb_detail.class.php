<?php
class Facebook_detail extends Model{

	public function __construct(){
		parent::__construct();
		$this->table = 'fb_detail';
		$this->id = 'id';
		$this->fields = array('token' => '',
							  'email_address' => '',
                              'base_domain' => '',
                              'expires' => '',
                              'secret'=>'',
                              'session_key'=>'',
                              'sig'=>'',
                              'uid'=>''
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
        if (count($row)> 0){
            $data = $fb_detail_cls->getFields();
            foreach($row as $key=>$val){
                $data[$key] = $val;
            }
            return $data;
        }
    }
    return null;
}
function FD_hasID($email_address){
    global $fb_detail_cls;
    $row = $fb_detail_cls->getRow('email_address =\''.$email_address.'\'');
    if (count($row)> 0){
       return true;
    }
    return false;
}
?>