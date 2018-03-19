<?php
class Payment_store extends Model{
	public function __construct(){
		parent::__construct();
		$this->table = 'payment_store';
		$this->id = 'id';
		$this->fields = array('id' => 0,
						'property_id' => 0,
						'banner_id' => 0,
						'agent_id' => 0,
						'bid' => 0,
						'bid_price' => 0,
						'offer' => 0,
						'offer_price' => 0,
						'notification_email' => 0,
						'notification_email_price' => 0,
						'focus' => 0,
						'focus_price' => 0,
						'home' => 0,
						'home_price' => 0,
						'package_id' => 0,
						'package_price' => 0,
						'cc_number' => '',
						'cc_exp_month' => '',
						'cc_exp_year' => '',
						'cc_ccv' => '',
						'cc_transid' => '',
						'amount' => 0,
						'cross' => 0,
						'payment_type' => '',
						'creation_time' => '0000-00-00 00:00:00',
						'notes' => '',
						'is_paid' => '',
						'is_change' => 0,
                        'is_disable'=>0,
                        'type'=>'',
                        'allow'=>0);
	}

    public function insert($data = array())
    {
        if ((int)@$data['agent_id'] <= 0) {
            return false;
        }
        $data_upd = array('amount' => @$data['amount'], 'package_price' => @$data['package_price']);

        $sql = 'SELECT id, amount, is_paid FROM ' . $this->table . ' WHERE agent_id = ' . (int)@$data['agent_id'];

        if (@$data['property_id'] > 0) {
            $sql .= ' AND property_id = ' . (int)@$data['property_id'];
            if (@$data['bid'] > 0) {
                $sql .= ' AND bid = 1';
            }

            if (@$data['offer'] > 0) {
                $sql .= ' AND offer = 1';
            }

            if (@$data['focus'] > 0) {
                $sql .= ' AND focus = 1';
            }

            if (@$data['home'] > 0) {
                $sql .= ' AND home = 1';
            }
            if (strlen(trim(@$data['type'])) > 0) {
                $sql .= ' AND type = "'.@$data['type'].'"';
            }

        } else if (@$data['banner_id'] > 0) {
            $sql .= ' AND banner_id = ' . (int)@$data['banner_id'];
            if (@$data['notification_email'] > 0) {
                $sql .= ' AND notification_email = 1';
            }
        }

        $row = $this->getRow($sql, true);
        if (is_array($row) && count($row) > 0 && (int)@$row['id'] > 0) {
            if ($row['is_paid'] == 0 && (float)$row['amount'] != (float)@$data['amount']) {
                $this->update($data_upd, 'id = ' . (int)@$row['id']);
            }
            return $row['id'];
        } else {
            if(strlen(trim($data['creation_time']))> 0){}else{
                $data['creation_time'] = date('Y-m-d H:i:s');
            }
            parent::insert($data);
            return $this->insertId();
        }
    }
	public function _insert($data = array()){
        if ((int)@$data['agent_id'] <= 0) {
			return false;
		}

        $row = $this->getCRow(array('id'),'package_id = '.$data['package_id'].'
                              AND agent_id = '.$data['agent_id'].'
                              AND amount = '.$data['amount'].'
                              AND is_paid = 0');
        if (is_array($row) and count($row) > 0){
            return $row['id'];
        }
        parent::insert($data);
	    return $this->insertId();
    }

	public function update($data = array(), $where_str = '') {
		parent::update($data, $where_str);
	}
	
	public function delete($where_str = '') {
		parent::delete($where_str);
	}

    public function parentInsert($data = array()) {
        parent::insert($data);
        return $this->insertId();
    }

}
