<?php
include_once ROOTPATH.'/includes/model.class.php';
class Twitter_detail extends Model{

	public function __construct(){
		parent::__construct();
		$this->table = 'twitter_detail';
		//$this->id = 'agent_id';
		$this->fields = array('token' => '',
							'token_secret' => '',
                            'agent_id' => '',
                            'username'=>'');
    }
}
if (!isset($twitter_detail_cls) || !($twitter_detail_cls instanceof Twitter_detail)) {
	$twitter_detail_cls = new Twitter_detail();
}
function TD_getInfo($provider_id){
    global $twitter_detail_cls;
    if ($provider_id != ''){
        $row = $twitter_detail_cls->getRow('agent_id =\''.$provider_id.'\'');
        if (is_array($row) and count($row)> 0){
            $result = array('token'=>$row['token'],
                            'token_sec'=>$row['token_secret']);
            return $result;
        }
    }
    return null;
}

function TD_hasID($provider_id){
    global $twitter_detail_cls;
    $row = array();
    $row = $twitter_detail_cls->getRow('agent_id =\''.$provider_id.'\'');
    if (is_array($row) and count($row)> 0){
       return true;
    }
    return false;
}
function TD_agentHasTwID($provider_id){
    global $agent_cls;
    $row = $agent_cls->getRow('SELECT *
                               FROM '.$agent_cls->getTable().'
                               WHERE provider_id = \''.$provider_id.'\'',true);
    if (is_array($row) and count($row) > 0){
        return true;
    }
    return false;
}

function TD_getTwitterAcc($agent_id){
    global $twitter_detail_cls,$agent_cls;
    $row = $twitter_detail_cls->getRow('SELECT *
                                        FROM '.$twitter_detail_cls->getTable().' AS t
                                        INNER JOIN '.$agent_cls->getTable().' AS a
                                        ON a.provider_id = t.agent_id
                                        WHERE a.agent_id = '.$agent_id,true);
    if (is_array($row) and count($row) > 0){
        return $row;
    }
    return null;
}
?>
