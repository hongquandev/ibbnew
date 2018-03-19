<?php
class UserOnline extends Model {
	private $timeout = 600;
    public function __construct() {
		parent::__construct();
		$this->table = 'user_online';
		$this->id = 'login_id';
		$this->fields = array('login_id' => 0,
							'agent_id' => 0,
							'last_active' => 0);
	}

    public function checkOnline(){
        if (isset($_SESSION['agent']) && $_SESSION['agent']['id'] > 0){
            $row = $this->getRow('agent_id = '.$_SESSION['agent']['id']);
            if (is_array($row) and count($row) > 0){
                $this->update(array('last_active'=>time(),'agent_id = '.$_SESSION['agent']['id']));
            }else{
                $this->insert(array('agent_id'=>$_SESSION['agent']['id'],
                                    'last_active'=>time()));
            }
        }
        //print_r($this->sql);
        //clear user inactive
        $this->delete('last_active < '.(time() - $this->timeout));
        //print_r($this->sql);
    }

    public function logout(){
        if (isset($_SESSION['agent']) && $_SESSION['agent']['id'] > 0){
            $this->delete('agent_id = '.$_SESSION['agent']['id']);
        }
    }
}