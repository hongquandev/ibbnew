<?php
class Email_log extends Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'email_log';
		$this->id = 'log_id';
		$this->fields = array('log_id' => 0,
							  'type' => '',
							  'time' => '0000-00-00 00:00:0',
                              'count'=>0);
	}

    public function createLog($type){
        $wh_str = "type='".$type."' AND time='".date('Y-m-d')."'";
        $row = $this->getCRow(array('count'),$wh_str);
        if (is_array($row) and count($row) > 0){
            $this->update(array('count'=>((int)$row['count'] + 1)),$wh_str);
        }else{
            $this->insert(array('type'=>$type,'time'=>date('Y-m-d'),'count'=>1));
        }
    }
}

if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
    $log_cls = new Email_log();
}

?>