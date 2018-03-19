<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/banner/inc/banner.php';
if (!isset($banner_cls) or !($banner_cls instanceof Banner)) {
    $banner_cls = new Banner();
}
/* function: getBannerByPropertyId
 *
 *
*/
function getBannerByPropertyId($property_id = 0)
{
    global $property_cls,$banner_cls;
        $lkB = '';
        if($property_id > 0)
        {
            $pro_rows = $property_cls->getRow('SELECT state, suburb FROM '.$property_cls->getTable().' WHERE property_id ='.$property_id, true);
			if(count($pro_rows) > 0 and is_array($pro_rows))
            {
                return getBannerByData($pro_rows);
            }
        }
    return $lkB;
}

function getBannerByAgentId($agent_id = 0)
{
    global $property_cls,$banner_cls,$agent_cls;
        $lkB = '';
        if($agent_id > 0)
        {
			$row = $property_cls->getRow('SELECT state, suburb FROM '.$property_cls->getTable().' WHERE agent_id ='.$agent_id, true);
            if(count($row) > 0 and is_array($row))
            {
                return getBannerByData($row);
            }
        }
    return $lkB;
}

function getBannerByDataEA($data = array())
    {
        global $property_cls,$banner_cls, $email_cls;
        // Find BAnner With Suburb in Email Alert
        $banner_ar = $data;
        if($data['email_id'] > 0)
        {
            $ea_data = $email_cls->getRow('SELECT state, suburb, postcode FROM '.$email_cls->getTable().' WHERE email_id ='.$data['email_id'], true);
            if(count($ea_data) > 0 and is_array($ea_data))
            {
                $banner_ar = $ea_data;
            }
        }
        return getBannerByData($banner_ar);
    }

function getBannerByData($data = array())
{
    $banner_ar = $data;
    if (count($banner_ar) > 0 && is_array($banner_ar) > 0) {
        $where_ar = array();
        if(isset($banner_ar['suburb']) and $banner_ar['suburb'] != '')
        {
            $sub_wh = "  ba.suburb LIKE '%".$banner_ar['suburb']."%'  ";
            if(isset($banner_ar['state']) and $banner_ar['state'] > 0)
            {
                $sub_wh = " (ba.suburb LIKE '%".$banner_ar['suburb']."%' OR ba.state = ".$banner_ar['state']." )";
            }
            $where_ar[] = $sub_wh;
        }
        if(isset($banner_ar['state']) and $banner_ar['state'] > 0)
        {
            $where_ar[] = "ba.state = ".$banner_ar['state'];
        }
        if(isset($banner_ar['postcode']) and $banner_ar['postcode'] > 0 )
        {
            $sub_wh = "ba.postcode = ".$banner_ar['postcode'];
            if(isset($banner_ar['state']) and $banner_ar['state'] > 0)
            {
                $sub_wh = " (ba.postcode LIKE '%".$banner_ar['postcode']."%' OR ba.state = ".$banner_ar['state']." )";
            }
            $where_ar[] = $sub_wh;
        }
        $where = (count($where_ar) > 0 ) ? implode(' AND ',$where_ar) : "1" ;
        return getBannerlist($where);
    }
    return '';
}
function getBannerlist($where = 1)
{
    global $banner_cls;
    $lkB = '';
    $date = date('Y-m-d');
    $brows = $banner_cls->getRows('SELECT banner_file, url FROM '.$banner_cls->getTable().' AS ba
                                                        WHERE   ba.status = 1
                                                                AND ba.agent_status = 1
                                                                AND ba.notification_email = 1
                                                                AND ba.pay_status = 2
                                                                AND ba.date_from <= "'.$date.'"
                                                                AND "'.$date.'" <= ba.date_to
                                                                AND '.$where.'
                                                        ORDER BY RAND() LIMIT 0,5' ,true);
    //die($banner_cls->sql);
    $totalRec = $banner_cls->getFoundRows();
    if (count($brows) > 0) {
        foreach($brows as $brow) {
            $banner_link = '<img src='.ROOTURL.'/store/uploads/banner/images/'.$brow['banner_file'].' width="280" alt="" />';
            $linkBanner = '<li style="padding-bottom:15px; padding-top:10px; margin-left:0px;list-style-type:none;">
                                            <a href="'.$brow['url'].'" target="_blank" >
                                            '.$banner_link.' </a></li>';
            $lkB.= $linkBanner;
        }
    }
    return $lkB;
}


