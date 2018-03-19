<?php
class User extends Model{
	/**
	Construct
	*/
	public function __construct() {
		parent::__construct();
		$this->table = 'users';
		$this->id = 'user_id';
		$this->fields = array('user_id' => 0,
						'firstname' => '',
						'lastname' => '',
						'username' => '',
						'password' => '',
						'email' => '',
						'role_id' => 0,
						'active' => 1);
	}
	
	public function login($username = '', $password = ''){
		$row = $this->getRow("username = '".$this->escape($username)."' AND password = '".encrypt($this->escape($password))."' AND active = 1");
		if (is_array($row) and count($row) > 0) {
            unset($_SESSION['Admin']);
			$_SESSION['Admin'] = array ("Logged" => TRUE, 
										"ID" => $row['user_id'], 
										"Level" => 1,  
										"EmailAddress" => $row['email'], 
										"Password" => $row['password'],
										'role_id' => $row['role_id']);
			return true;
		} else {
			return false;
		}
	}
	
	public function emailExist($email = '') {
		$row = $this->getRow("email = '".$this->escape($email)."'");
		if (is_array($row) and count($row) > 0) {
			return true;
		}
		return false;
	}
	
	public function logout() {
		$_SESSION['Admin'] = null;
		unset($_SESSION['Admin']);
        $_SESSION['Admin_isLogin'] = false;
        redirect('index.php');
        //msg_alert('You have logged out.','index.php');
		//unset($_SESSION['Admin']);
	}
}
?>