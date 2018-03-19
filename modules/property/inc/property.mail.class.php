<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
class Mail_Property {
	private $winner_obj = array('email_address' => '','sms' => '');
    private $vendor_obj = array('email_address' => '','sms' => '','name' => '');
    private $lawyer_obj = array('email_address' => '','sms' => '','name' => '');
    private $agent_obj  = array('email_address' => '','sms' => '','name' => '');
    private $bidder_obj = array('email_address' => array(),'sms' => array() );
    private $watcher_obj = array('email_address' => array(),'sms' => array() );

    private $data = array();
    private $property_id = 0;
    private $agent_id = 0;
    private $vendor_id = 0;
    private $offer_price = 0;

	private $objs = array();
	public function __construct($agent_id,$property_id,$offer_price=0) {
		global $agent_cls, $bid_cls, $watchlist_cls, $config_cls,$property_cls;
        if($property_id > 0 and $agent_id > 0 )
        {
            $this->property_id = $property_id;
            $this->agent_id = $agent_id ;

            /*$this->objs['agent_cls'] &= $agent_cls;
            $this->objs['bid_cls'] &= $bid_cls;
            $this->objs['watchlist_cls'] &= $watchlist_cls;
            $this->objs['config_cls'] &= $config_cls;*/

            $row = $property_cls->getRow('property_id='.$property_id);
            if(count($row) > 0 and is_array($row))
            {
                $this->vendor_id = $row['agent_id'];
                $this->data = $row;
            }


        }
        if($offer_price != 0)
        {
            $this->offer_price = showPrice($offer_price);
        }
	}

    public function SetDataProperty()
    {
        global $property_cls;
        if($this->property_id > 0)
        {
            $row = $property_cls->getRow('property_id='.$this->property_id);
            if(is_array($row) and count($row) > 0 )
            {
                $this->data = $row;
            }

        }
        return $this;
    }

    public  function GetAgent()
    {
        global $agent_cls;
        if($this->agent_id > 0 )
        {
            $row = $agent_cls->getRow('agent_id='.$this->agent_id);
            if(is_array($row) and count($row) > 0)
            {
                if ($row['notify_email'] == 1 OR TRUE) {
                    $this->agent_obj['email_address'] = $row['email_address'];
                    $this->agent_obj['name'] = $row['firstname'].' '.$row['lastname'];
                }
            }
        }
        return $this;
    }
    /**
	function : GetLawyer
	**/

	public function GetLawyer() {
        global $agent_cls;
        if($this->vendor_id > 0 )
        {
            $agent_row = $agent_cls->getRow("SELECT a_l.*,a.notify_email,a.notify_sms,a.allow_lawyer
										FROM  ".$agent_cls->getTable()." AS a , ".$agent_cls->getTable('agent_lawyer')." AS a_l
										WHERE a_l.agent_id = a.agent_id
                                            AND a.agent_id = ".$this->vendor_id."
                                            AND a.is_active = 1",true);
            if (is_array($agent_row) && count($agent_row) > 0) {
                if ($agent_row['allow_lawyer'] == 1) {
                    $this->lawyer_obj['email_address'] = $agent_row['email'];
                    $this->lawyer_obj['name'] = $agent_row['name'];
                }

                if ($agent_row['allow_lawyer'] == 1) {
                    $this->lawyer_obj['sms'] = $agent_row['mobilephone'];
                }
            }
        }

		return $this;
	}

	/**
	function : GetVendor
	**/

	public function GetVendor() {
        global $agent_cls;
        if($this->vendor_id > 0 )
        {
            $agent_row = $agent_cls->getRow("SELECT a.*
                                            FROM  ".$agent_cls->getTable()." AS a , ".$agent_cls->getTable('agent_type')." AS a_t
                                            WHERE a.type_id = a_t.agent_type_id
                                                    AND a.agent_id = ".$this->vendor_id."
                                                    AND a.is_active = 1",true);
            if (is_array($agent_row) && count($agent_row) > 0) {
                if ($agent_row['notify_email'] == 1) {
                    $this->vendor_obj['email_address'] = $agent_row['email_address'];
                    $this->vendor_obj['name'] = $agent_row['firstname'].' '.$agent_row['lastname'];
                }

                if ($agent_row['notify_sms'] == 1) {
                    $this->vendor_obj['sms'] = $agent_row;
                }
            }
        }
		return $this;
	}



	/**
	function : GetBidder
	**/
	public function GetBidder() {
        global $agent_cls, $bid_cls;
        //Get Winner Email
            $row = Bid_getLastBidByPropertyId((int)$this->property_id);
            if(is_array($row) and count($row) > 0 )
            {
                $winner_email= A_getEmail($row['agent_id']);
                $this->winner_obj['email_address'] = $winner_email;
                $this->winner_obj['sms'] = '';
            }
        //END

        $bid_rows = $bid_cls->getRows('SELECT   DISTINCT
                                                agt.agent_id,
                                                agt.email_address,
                                                agt.mobilephone,
												agt.notify_email,
												agt.notify_sms,
												agt.firstname,
												agt.lastname

                                                FROM '.$agent_cls->getTable().' AS agt,'.$bid_cls->getTable().' AS bid
                                                WHERE
                                                    agt.agent_id = bid.agent_id
                                                    AND agt.is_active = 1
                                                    AND bid.property_id = '.$this->property_id.'
                                                ORDER BY bid.price DESC',true);


		if (is_array($bid_rows) && count($bid_rows) > 0) {
			foreach ($bid_rows as $bid_row) {
                if(strcasecmp($bid_row['email_address'],@$this->win_ar['email_address']) != 0)
                {
					if ($bid_row['notify_email'] == 1) {
						$this->bidder_obj['email_address'][] = $bid_row['email_address'];
					}

					if ($bid_row['notify_sms'] == 1 && strlen(trim($bid_row['mobilephone'])) > 0) {
						$this->bidder_obj['sms'][] = $bid_row['mobilephone'];
					}
                }

			}//end foreach
		}//end if

		return $this;
	}


	/**
	function : scanWatchlist
	**/
	public function GetWatchlist() {
        global $agent_cls, $watchlist_cls;
        $watchlist_rows = $watchlist_cls->getRows('SELECT DISTINCT agt.email_address, agt.mobilephone, agt.notify_email,
																agt.notify_sms, agt.firstname, agt.lastname
																FROM '.$watchlist_cls->getTable().' AS wl,'.$agent_cls->getTable().' AS agt
																WHERE wl.agent_id = agt.agent_id
																		AND agt.is_active = 1
																		AND wl.property_id = '.$this->property_id,true);


		if (is_array($watchlist_rows) && count($watchlist_rows) > 0) {
			foreach ($watchlist_rows as $wl_row) {

				if (strcasecmp($wl_row['email_address'],@$this->winner_obj['email_address']) != 0 ) {

					if ($wl_row['notify_email'] == 1) {
						$this->watcher_obj['email_address'][] = $wl_row['email_address'];
					}

					if ($wl_row['notify_sms'] == 1 && strlen(trim($wl_row['mobilephone'])) > 0) {
						$this->watcher_obj['sms'][] = $wl_row['mobilephone'];
					}

				}
			}//end foreach
		}//end if

		return $this;
	}

    public  function  replace_content($cont)
    {
        $ar_input = array('[buyer_name]','[agent_name]','[buyer_email]','[agent_email]','[ID]','[ROOTURL]','[offer_price]');
        $ar_re = array($this->agent_obj['name'],$this->vendor_obj['name'],$this->agent_obj['email_address'],$this->vendor_obj['email_address'],$this->property_id,ROOTURL,$this->offer_price);
        $content = str_replace($ar_input,$ar_re,$cont);
        return $content;
    }

    /**
	function : sendMailLawyer
     *
     *
	**/

	public function SendMailLawyer() {
		global $config_cls,$property_cls,$banner_cls;
		$email_from = $config_cls->getKey('general_contact_email');

		if (isset($this->lawyer_obj['email_address']) and $this->lawyer_obj['email_address'] !='') {

            $msg = $config_cls->getKey('email_lawyer_stop_bid_msg');
			$msg = str_replace(array('{property_id}','[lawyer_name]'),array($this->data['property_id'],$this->lawyer_obj['name']),$msg);
            $msg = $this->replace_content($msg);
            $subject = $config_cls->getKey('email_lawyer_stop_bid_msg_subject');
            //$subject = 'ACCEPTED OFFER: [ID]';
            $subject = str_replace(array('[ID]'),array($this->data['property_id']),$subject);
            $lkB = getBannerByPropertyId($this->data['property_id']);
			$this->Send_Email($email_from,$this->lawyer_obj['email_address'],$msg,$subject,$lkB);
		}
		if (is_array($this->vendor_obj['sms']) && count($this->vendor_obj['sms']) > 0) {
			$msg = $config_cls->getKey('sms_vendor_stop_bid_msg');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);
			$to = $this->lawyer_obj['sms'];
			sendSMS($msg,$to);
		}

		return $this;
	}
	/**
	function : sendVendor
     *
     *
	**/

	public function SendMailVendor() {
		global $config_cls,$property_cls,$banner_cls;
		$email_from = $config_cls->getKey('general_contact_email');

		if (isset($this->vendor_obj['email_address']) and $this->vendor_obj['email_address'] !='') {
			$msg = $config_cls->getKey('email_offer_vendor');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);
            $msg = $this->replace_content($msg);
            $subject = $config_cls->getKey('email_offer_vendor_subject');
            //$subject = 'ACCEPTED OFFER: [ID]';
            $subject = str_replace(array('[ID]'),array($this->data['property_id']),$subject);
            $lkB = getBannerByPropertyId($this->data['property_id']);
			$this->Send_Email($email_from,$this->vendor_obj['email_address'],$msg,$subject,$lkB);
		}
		if (is_array($this->vendor_obj['sms']) && count($this->vendor_obj['sms']) > 0) {
			$msg = $config_cls->getKey('sms_vendor_stop_bid_msg');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);
			$to = $this->vendor_obj['sms']['mobilephone'];
			sendSMS($msg,$to);
		}
		return $this;
	}

    /**
	function : sendVendor
	**/
	public function SendMailAgent() {
		global $config_cls,$property_cls,$banner_cls;
		$email_from = $config_cls->getKey('general_contact_email');

		if (isset($this->agent_obj['email_address']) and $this->agent_obj['email_address'] != '') {
			$msg = $config_cls->getKey('email_offer_agent');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);

            $msg = $this->replace_content($msg);
            //$subject = 'OFFER: [ID] SUCCESSFUL';
            $subject = $config_cls->getKey('email_offer_agent_subject');
            $subject = str_replace(array('[ID]'),array($this->property_id),$subject);
            $lkB = getBannerByPropertyId($this->data['property_id']);
			$this->Send_Email($email_from,$this->agent_obj['email_address'],$msg,$subject,$lkB);
		}
        //die (print_r($this->agent_obj['email_address']));
		if (is_array($this->agent_obj['sms']) && count($this->agent_obj['sms']) > 0) {
			$msg = $config_cls->getKey('sms_vendor_stop_bid_msg');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);
			$to = $this->agent_obj['sms']['mobilephone'];
			sendSMS($msg,$to);
		}

		return $this;
	}

	/**
	function : sendWinner
	**/
	public function SendEmailWinner() {
        global $config_cls,$property_cls,$banner_cls,$log_cls;
		if (is_array($this->winner_obj['email_address']) && count($this->winner_obj) > 0) {

			$msg = $config_cls->getKey('email_offer_agent');
			$msg = str_replace(array('[ID]'),array($this->data['property_id']),$msg);
            $msg = $this->replace_content($msg);
            $email_from = $config_cls->getKey('general_contact_email');
            $subject = 'You are the successful bidder!';
            $lkB = getBannerByPropertyId($this->data['property_id']);
            $this->Send_Email($email_from,$this->winner_obj['email_address'],$msg,$subject,$lkB);
            include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
            $log_cls->createLog('notify');
			$to = $this->winner_obj['sms'];
			sendSMS($msg,$to);
		}

		return $this;
	}

	/**
	function : sendReceiver ( people who in watchlist AND bidder)
	**/
	public function SendMailBidderAndWatcher() {
        global $config_cls,$property_cls,$banner_cls,$log_cls;
        $email_from = $config_cls->getKey('general_contact_email');
		if (   is_array($this->bidder_obj['email_address']) AND count($this->bidder_obj['email_address']) > 0   ) {
			$msg = $config_cls->getKey('email_offer_bidder_watcher');
			$msg = str_replace(array('{property_id}'),array($this->data['property_id']),$msg);
            $msg = $this->replace_content($msg);
            $subject = $config_cls->getKey('email_offer_bidder_watcher_subject');
            //$subject = 'Property [ID] had sold';
            $subject = str_replace(array('[ID]'),array($this->data['property_id']),$subject);
            $lkB = getBannerByPropertyId($this->data['property_id']);
			$emails_tobidder = array_diff($this->bidder_obj['email_address'],$this->watcher_obj['email_address']);
            if(is_array($emails_tobidder) AND count($emails_tobidder) > 0)
                foreach($emails_tobidder as $email)
                {
                    $this->watcher_obj['email_address'][] = $email;
                }
            $emails_toWatcherBidder = array_diff($this->watcher_obj['email_address'],array($this->agent_obj['email_address']));
			    /*print_r($this->watcher_obj['email_address']);
                print_r($this->bidder_obj['email_address']);
                print_r($emails_toWatcherBidder);*/
            if(is_array($emails_toWatcherBidder) AND count($emails_toWatcherBidder) > 0)
                $this->Send_Email($email_from,$emails_toWatcherBidder,$msg,$subject,$lkB);

            /*$this->Send_Email($email_from,$emails_tobidder,$msg,$subject,$lkB);*/
            //print_r($this->watcher_obj['email_address']);
            //print_r($this->bidder_obj['email_address']);
		}
        try{
            if (is_array($this->bidder_obj['sms']) && count($this->bidder_obj['sms']) > 0) {
                $to = array();
                foreach ($this->bidder_obj['sms'] as $receiver) {
                    $to[] = $receiver['mobilephone'];
                }
                $msg = $config_cls->getKey('sms_agent_stop_bid_msg');
                $msg = preg_replace(array('{property_id}'),array($this->data['property_id']),$msg);
                foreach($to as $to_)
                {
                    sendSMS($msg,$to_);
                }
            }
        }
        catch(Exception $e)
        {
            return $this;
        }
		return $this;
	}
    
    /**
	function : sendServiceProvider
	**/
	public function SendEmailServiceProvider($action = '') {
        global $config_cls,$property_cls,$banner_cls,$log_cls,$property_provider_email_cls;
        if($this->property_id > 0 )
        {
            $general_service_provider_email = $config_cls->getKey('general_service_provider_email');
            $row = $property_provider_email_cls->getRow('property_id='.$this->property_id);
            if(is_array($row) and count($row) > 0)
            {
                $email_from = $config_cls->getKey('general_contact_email');
                $emailto = (strlen($row['email']) > 0) ? $row['email'] : ((strlen($general_service_provider_email) > 0) ? $general_service_provider_email : $email_from );
                $msg = $config_cls->getKey('email_service_provider_msg');
    			$msg = str_replace(array('[ID]','[ACTION]'),array($this->data['property_id'],$action),$msg);
                $msg = $this->replace_content($msg);
                
                $subject = $config_cls->getKey('email_service_provider_msg_subject');
                $subject = str_replace(array('[ID]'),array($this->data['property_id']),$subject);
                $lkB = getBannerByPropertyId($this->data['property_id']);
                $this->Send_Email($email_from,$emailto,$msg,$subject,$lkB);
                include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
                $log_cls->createLog('notify');
    			//$to = $this->winner_obj['sms'];
    			//sendSMS($msg,$to);
            }
        }
		return $this;
	}
function Send_Email($from, $to, $message,$subject, $ban = '') {
    include_once ROOTPATH.'/modules/general/inc/bids.php';
	global $config_cls;
    sendEmail_func($from,$to,$message,$subject,$ban);
    include_once ROOTPATH.'/modules/general/inc/email_log.class.php';
    if (!isset($log_cls) || !($log_cls instanceof Email_log)) {
        $log_cls = new Email_log();
    }
    $log_cls->createLog('offer_accept');

	return $message;
}

function sendSMS($text, $to) {
	global $sms_cls, $sms_log_cls, $config_cls;
	$sms_enable = $config_cls->getKey('sms_enable');
	if ($sms_enable == 1) {
		$sms_cls->send($text,$to);
		$sms_cls->parseResponse();
		$sms_log_cls->insert(array('message' => $text,'created_at' => date('Y-m-d H:i:s'),'status' => $sms_cls->getStatus()));
	}
}
}
//end class
