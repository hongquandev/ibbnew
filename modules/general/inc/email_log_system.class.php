<?php
/*
SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `email_log_system`
-- ----------------------------
DROP TABLE IF EXISTS `email_log_system`;
CREATE TABLE `email_log_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `data` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

 * */
class EmailLogSystem extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'email_log_system';
        $this->id = 'id';
        $this->fields = array('id' => 0,
            'date_create' => '0000-00-00',
            'status' => '',
            'data' => ''
        );
    }

    /*---------*/
    public function addLogEmail($data = array())
    {
        $id = 0;
        if (is_array($data) && count($data) > 0) {
            $data_ar = array();
            $data_ar['status'] = 0;
            $data_ar['date_create'] = date('Y-m-d H:i:s');
            $data_ar['data'] = serialize($data);
            $this->insert($data_ar);
            $id = $this->insertId();
        }
        return $id;
    }
}

/*----------*/
if (!isset($email_log_system) or !($email_log_system instanceof EmailLogSystem)) {
    $email_log_system = new EmailLogSystem();
}

?>