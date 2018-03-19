<?php

class Property extends Model
{
    /**
     * construct
     */
    const PAY_UNKNOWN = 0;
    const PAY_PENDING = 1;
    const PAY_COMPLETE = 2;
    const CAN_SHOW = 2;
    const SOLD_UNKNOWN = 0;
    const SOLD_COMPLETE = 1;
    const EXPIRE_SECOND = 10;//10 seconds
    const AUCTION_CODE_AGENT = 1;
    const AUCTION_CODE_ALL = 2;
    const AUCTION_CODE_NOT_AGENT = 0;
    const OPTION_AUCTION_LIVE = 0;

    /* const PAY_UNKNOWN = 0;
     const PAY_PENDING = 1;
     const PAY_COMPLETE = 2;
     const CAN_SHOW = 1;*/
    public function __construct()
    {
        parent::__construct();
        $this->table = 'property_entity';
        $this->id = 'property_id';
        $this->fields = array('property_id' => 0,
            'auction_sale' => 0,
            'type' => 0,
            'kind' => 0,
            'description' => '',
            'address' => '',
            'suburb' => '',
            'state' => 0,
            'postcode' => '',
            'country' => 0,
            'price' => 0.00,
            'period' => 0,
            'price_on_application' => 0.00,
            'bedroom' => 0,
            'bathroom' => 0,
            'parking' => 0,
            'land_size' => 0,
            'car_space' => 0,
            'car_port' => 0,
            'frontage' => 0,
            'release_time' => '0000-00-00 00:00:00',
            'start_time' => '0000-00-00 00:00:00',
            'end_time' => '0000-00-00 00:00:00',
            //THE LAST TIME TO BID
            'last_bid_time' => '0000-00-00 00:00:00',
            //last_bid_time IS THE LAST BID TIME OF BIDDER WHEN end_time < "CURRENT TIME"
            'open_for_inspection' => 0,
            'notify_inspect_time' => 0,
            'open_time' => 0,
            'auction_blog' => 0,
            'contact_by_bidder' => 0,
            'agent_id' => 0,
            'nd2_phone_number' => '',
            'nd2_email_address' => '',
            'uniqueID' => '',
            'agentID' => '',
            'pay_status' => 0,
            'active' => 1,
            'agent_active' => 1,
            'views' => 0,
            'dateviews' => '0000-00-00',
            'hide_for_live' => 0,
            'focus' => 0,
            'focus_flag' => 0,
            'focus_status' => 0,
            //FOR HOME PAGE
            'feature' => 0,
            //FOR HOME PAGE
            'stop_bid' => 0,
            //STOP BIDDING WITH EACH SPECIFIC PROPERTY
            'set_jump' => 0,
            'jump_flag' => 0,
            'jump_status' => 0,
            'creation_date' => '0000-00-00',
            'scan' => 0,
            'locked' => 0,
            'step' => 0,
            'confirm_sold' => 0,
            'sold_time' => '0000-00-00 00:00:00',
            'stop_time' => '0000-00-00 00:00:00',
            'package_id' => 0,
            'livability_rating_mark' => 0,
            'green_rating_mark' => 0,
            'owner' => '',
            'last_update_time' => '0000-00-00 00:00:00',
            'creation_datetime' => '0000-00-00 00:00:00',
            'posted_to_live_time' => '0000-00-00 00:00:00',
            //FOR THE BLOCK
            'set_count' => '',
            'admin_created' => 0,
            'date_to_reg_bid' => '0000-00-00',
            'agent_manager' => 0,
            'autobid_enable' => 0,
            'min_increment' => 0,
            'max_increment' => 0,
            'change_increment' => 0,
            'show_agent_logo' => 0,
            'no_more_bid' => 0,
            'post' => 0,
            //FOR THE BLOCK & AGENT
            'lock_bid' => 0,
            'is_record' => 0,
            'listening' => '',
            'buynow_price' => '',
            'buynow_buyer_id' => '',
            'buynow_status' => 0,
            'advertised_price_from' => 0,
            'advertised_price_to' => 0,
            'price_view' => '',
            //ROR REA XML
            'bond' => 0,
            'ensuite' => 0,
            'garages' => 0,
            'headline' => '',
            'isHomeLandPackage' => 0,
            'lotNumber' => 0,
            'solarPanels' => 0,
            'streetView' => 0,
            'toilets' => 0,
            'unitNumber' => 0,
            'energyRating' => 0,
            'withdrawn' => 0,
            'underoffer' => 0,
            'bank_info' => '',
            'slug' => '',
        );
        $this->fields_valid = array('auction_sale' => array('label' => 'Auction / Sale', 'fnc' => array('isInt' => null)),
            'type' => array('label' => 'Type', 'fnc' => array('isInt' => null)),
            'description' => array('label' => 'Description', 'fnc' => array('isRequire' => null)),
            'address' => array('label' => 'Address', 'fnc' => array('isRequire' => null)),
            'suburb' => array('label' => 'Suburb', 'fnc' => array('isRequire' => null)),
            'state' => array('label' => 'State', 'fnc' => array('isInt' => null)),
            'postcode' => array('label' => 'Postcode', 'fnc' => array('isInt' => null)),
            'country' => array('label' => 'Country', 'fnc' => array('isBigger' => 0), 'fnc_msg' => array('isBigger' => 'is require.')),
            'price' => array('label' => 'Price', 'fnc' => array('isInt' => null)),
            'bedroom' => array('label' => 'Bedroom', 'fnc' => array('isInt' => null)),
            'bathroom' => array('label' => 'Bathroom', 'fnc' => array('isInt' => null)));
    }

    public function getPayStatus($val = null)
    {
        $ar = array(self::PAY_UNKNOWN => 'Pending',
            self::PAY_PENDING => 'Payment received',
            self::PAY_COMPLETE => 'Completed');
        if ($val == null) {
            return $ar;
        }
        return isset($ar[$val]) ? $ar[$val] : $ar[self::PAY_UNKNOWN];
    }

    public function getValuePay($status)
    {
        $ar = array('Pending' => self::PAY_UNKNOWN,
            'Payment received' => self::PAY_PENDING,
            'Completed' => self::PAY_COMPLETE);
        return isset($ar[$status]) ? $ar[$status] : '';
    }

    public function isAdminCreated($property_id)
    {
        $row = $this->getRow('SELECT admin_created FROM ' . $this->getTable() . ' WHERE property_id = ' . (int)$property_id, true);
        if (is_array($row) and count($row) > 0) {
            return $row['admin_created'];
        }
        return 0;
    }

    /**
     * @ function : invalidRegion
     * @ param : region
     * @ output : bool
     **/
    public function invalidRegion($region)
    {
        // global $property_cls;
        $region = strtoupper($region);
        $this->sql = "SELECT c.id
                      FROM " . $this->getTable('code') . " AS c
                      WHERE CONCAT(UCASE(suburb),' ',(SELECT reg_1.region_id
							FROM " . $this->getTable('regions') . " AS reg_1
							WHERE reg_1.code = c.state LIMIT 0,1),' ',pcode) LIKE '%" . $region . "%'";
        //$sql = $this->sql;
        $row = $this->getRow($this->sql, true);
        if (is_array($row) and count($row) > 0) {
            return false;
        }
        return true;
    }

    /**
     * @ function : getAddress
     * @ param : property_id
     * @ output : string
     **/
    public function getAddress($property_id = 0)
    {
        $row = $this->getRow('SELECT pro.address,
									 pro.suburb,
									 pro.postcode,
									(SELECT reg1.name
									FROM ' . $this->getTable('regions') . ' AS reg1
									WHERE reg1.region_id = pro.state
									) AS state_name,

									(SELECT reg2.code
									FROM ' . $this->getTable('regions') . ' AS reg2
									WHERE reg2.region_id = pro.state
									) AS state_code,

									(SELECT reg3.name
									FROM ' . $this->getTable('regions') . ' AS reg3
									WHERE reg3.region_id = pro.country
									) AS country_name
									 
							  FROM ' . $this->getTable() . ' AS pro
							  WHERE pro.property_id = ' . $property_id, true);
        if (is_array($row) && count($row) > 0) {
            return implode(', ', array($row['address'], $row['suburb'], $row['state_code'], $row['postcode'], $row['country_name']));
        }
        return '';
    }

    /**
     * @ function : getDetailLink
     * @ param : property_id
     * @ output : string
     **/
    public function getDetailLink($property_id = 0)
    {
        $row = $this->getRow('SELECT pro.address,
									 pro.suburb,
									 pro.postcode,
									(SELECT reg1.name
									FROM ' . $this->getTable('regions') . ' AS reg1
									WHERE reg1.region_id = pro.state
									) AS state_name,

									(SELECT reg2.code
									FROM ' . $this->getTable('regions') . ' AS reg2
									WHERE reg2.region_id = pro.state
									) AS state_code,

									(SELECT reg3.name
									FROM ' . $this->getTable('regions') . ' AS reg3
									WHERE reg3.region_id = pro.country
									) AS country_name

							  FROM ' . $this->getTable() . ' AS pro
							  WHERE pro.property_id = ' . $property_id, true);
        if (is_array($row) && count($row) > 0) {
            $rowaddress = str_replace(' ', '-', $row['address']);
            $rowaddress = str_replace(',', '', $rowaddress);
            $rowaddress = (substr($rowaddress, -1) == '-') ? substr($rowaddress, 0, -1) : $rowaddress;
            $rowsuburb = str_replace(' ', '-', $row['suburb']);
            $detail_link = ROOTURL . "/" . strtolower($row['state_code']) . "/for-sale/$rowsuburb/$rowaddress/id-" . $property_id;
            return $detail_link;
        }
        return '';
    }

    /**
     * @ function : isAuction
     * @ param : property_id
     * @ output : bool
     * --------
     **/
    public function isAuction($property_id = 0)
    {
    }

    /**
     * @ function : hasTime
     * @ param : property_id
     * @ output : bool
     * ----------
     * check start_time and end_time is valid
     **/
    public function hasTime($property_id = 0)
    {
        //$row = $this->getRow('property_id = '.$property_id);
        $row = $this->getRow('SELECT start_time, end_time FROM ' . $this->table . ' WHERE property_id = ' . (int)$property_id, true);
        if (is_array($row) && count($row) > 0) {
            if (!Validate::isDateTime(array($row['start_time'])) || !Validate::isDateTime(array($row['end_time']))) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @ function : isExist
     * @ param : property_id
     * @ output : bool
     **/
    public function isExist($property_id = 0)
    {
        //$row = $this->getRow('property_id = '.$property_id);
        $row = $this->getRow('SELECT property_id FROM ' . $this->table . ' WHERE property_id = ' . (int)$property_id, true);
        if (is_array($row) && count($row) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @ function : lock
     * @ param : property_id
     * @ output : void
     **/
    public function lock($property_id = 0)
    {
        $this->update(array('locked' => 1), 'property_id = ' . $property_id);
    }

    /**
     * @ function : unLock
     * @ param : property_id
     * @ output : void
     **/
    public function unLock($property_id = 0)
    {
        $this->update(array('locked' => 0), 'property_id = ' . $property_id);
    }

    /**
     * @ function : isLocked
     * @ param : property_id
     * @ output : bool
     **/
    public function isLocked($property_id = 0)
    {
        $row = $this->getRow('SELECT locked FROM ' . $this->getTable() . ' WHERE property_id = ' . $property_id, true);
        //$this->freeResult();
        if (is_array($row) && count($row) > 0) {
            return $row['locked'] == 1 ? true : false;
        }
        return false;
    }

    /**
     * @ function : isExpire
     * @ param : property_id
     * @ output : bool
     **/
    public function isExpire($property_id = 0)
    {
        $row = $this->getRow('SELECT `time`
							  FROM ' . $this->getTable('bids') . ' AS bid
							  WHERE bid.property_id = ' . $property_id . '
							  ORDER BY bid.time DESC', true);
        //$this->freeResult();
        if (is_array($row) && count($row) > 0) {
            if (remainTime(date('Y-m-d H:i:s'), $row['time']) >= self::EXPIRE_SECOND) {
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     **/
    public function isTheBlock($property_id = 0)
    {
        $row = $this->getRow('SELECT pro.property_id
							  FROM ' . $this->getTable() . ' AS pro
							  INNER JOIN ' . $this->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
											(SELECT agt_typ.agent_type_id
											FROM ' . $this->getTable('agent_type') . ' AS agt_typ
											WHERE agt_typ.title = \'theblock\')
							  WHERE property_id = ' . (int)$property_id, true);
        if (is_array($row) && count($row) > 0) {
            return true;
        }
        return false;
    }

    public function isAgent($property_id = 0)
    {
        $row = $this->getRow('SELECT pro.property_id
							  FROM ' . $this->getTable() . ' AS pro
							  INNER JOIN ' . $this->getTable('agent') . ' AS agt ON pro.agent_id = agt.agent_id AND agt.type_id IN
											(SELECT agt_typ.agent_type_id
											FROM ' . $this->getTable('agent_type') . ' AS agt_typ
											WHERE agt_typ.title = \'agent\')
							  WHERE property_id = ' . (int)$property_id, true);
        if (is_array($row) && count($row) > 0) {
            return true;
        }
        return false;
    }
    /*public function update($datas = array(), $where_str = '')
    {
        try {
            parent::update($datas, $where_str);
            //print_r($this->sql);
            if (is_array($datas) and count($datas) > 0 and strlen($where_str) > 0) {
                foreach ($datas as $key => $value) {
                    if($key == 'confirm_sold' && $value == Property::SOLD_COMPLETE){
                        break;
                    }
                }
            }
        } catch (Exception $er) {

        }
    }*/
}
