<script type="text/javascript" src="../modules/general/templates/js/jquery.min.js"></script>
<script type="text/javascript" src="../modules/general/templates/js/highcharts.src.js"></script>
<script type="text/javascript" src="../modules/general/templates/js/admin-report.js"></script>

<div style="margin: 0 auto; width: 1140px" id="dash" class="dash-home-admin-ie7">
    <div style="float: left; width: 400px; height:500px;" id="leftdash" >
<?php
include_once ROOTPATH.'/modules/property/inc/property.class.php';
include_once 'inc/rp_pages.php';
include_once 'inc/rp_banner.php';
include_once 'inc/rp_agent.php';
include_once 'inc/rp_bids.php';
include_once 'inc/rp_sold.php';
include_once 'inc/rp_new_property.php';
global $property_cls;
if (!$property_cls){
    $property_cls = new Property();
}

$row = $property_cls->getRows("auction_sale = '10' order by ". $property_cls->id. ' desc limit 0,5');

if ($property_cls->hasError()){
    print_r($property_cls->getError());
}

?>

<table style="margin: 10px;" width="95%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <th colspan="3" class="top">
            <span style="font-weight: bold !important;" class="span-dash-home-admin-a">Top 5 New Private Sale</span>
            <span style="float:right" class="view-all span-dash-home-admin-b"><a href="?module=property&action=list&token=<?php echo $token?>">View All</a></span>
        </th>
    </tr>
    <tr>
        <th width="10%">
            <span>ID</span>
        </th>
        <th>
            <span>Address</span>
        </th>
        <th width="30%" class="th-second">
            <span>Price</span>
        </th>
    </tr>
    <tr>
        <td colspan="3">
<?php foreach($row as $col): ?>    
            <div id="row">
            <span style="float: left;margin-right: 19px;margin-left:0px !important;"><?php echo $col['property_id'].'    '; ?></span>
            <span id="span-dash-home-admin-ie7"><?php echo safecontent($col['address'],35).'...'; ?></span>
            <span><?php printf('%s', showPrice($col['price'])); ?></span>
            <div class="clr"></div>
            </div>
<?php endforeach; ?>
        </td>
    </tr>
</table>

<?php


    $row = $property_cls->getRows("auction_sale = '9' order by ". $property_cls->id. ' desc limit 0,5');

    if ($property_cls->hasError()){
        print_r($property_cls->getError());
    }
?>

    <table style="margin: 10px;" width="95%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="3" class="top">
                <span style="font-weight: bold !important;"  class="span-dash-home-admin-a">Top 5 New Auction</span>
                <span style="float:right" class="view-all span-dash-home-admin-b"><a href="?module=property&action=list&token=<?php echo $token?>">View All</a></span>
            </th>
        </tr>
        <tr>
            <th width="10%">
                <span>ID</span>
            </th>
            <th>
                <span>Address</span>
            </th>
            <th width="30%" class="th-second">
                <span>Price</span>
            </th>
        </tr>
        <tr>
        <td colspan="3">
<?php foreach($row as $col): ?>
            <div id="row">
            <span style="float: left;margin-right: 19px;margin-left:0px !important;"><?php echo $col['property_id']; ?></span>
            <span id="span-dash-home-admin-ie7"><?php echo $col['address']; ?></span>
            <span><?php printf('%s', showPrice($col['price'])); ?></span>
            <div class="clr"></div>
            </div>

<?php endforeach; ?>
        </td>
    </tr>
    </table>

<?php

    include_once ROOTPATH.'/modules/agent/inc/agent.php';

    $rows = $agent_cls->getRows("select agent_id,firstname, lastname, email_address from agent order by ". $agent_cls->id. ' desc limit 0,5',true);
    if ($agent_cls->hasError()){
        print_r($agent_cls->getError());
    }
?>

        <table style="margin: 10px;" width="95%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <th colspan="3" class="top">
                <span style="font-weight: bold !important;"  class="span-dash-home-admin-a">Top 5 New Customer</span>
                <span class="view-all span-dash-home-admin-b" style="float:right"><a href="?module=agent&token=<?php echo $token?>">View All</a></span>
            </th>
        </tr>
        <tr>
            <th width="10%">
                <span>ID</span>
            </th>
            <th>
                <span>Fullname</span>
            </th>
            <th width="30%" class="th-second">
                <span>Email</span>
            </th>
        </tr>

        <tr>
        <td colspan="3">
<?php 
	if (is_array($rows) && count($rows) > 0) :
	foreach($rows as $col):
	?>
            <div id="row">
            <span style="float: left;margin-right: 19px;margin-left:0px !important;"><?php echo $col['agent_id']; ?></span>
            <span id="span-dash-home-admin-ie7"><?php echo $col['firstname']. ' '. $col['lastname']; ?></span>
            <span><?php echo $col['email_address']; ?></span>
            <div class="clr"></div>
            </div>
<?php 
	endforeach; 
	endif;
	?>
        </td>
    </tr>
    </table>
    


</div>
<!-- Tab Right -->
<div id="container" class="container-home-admin-ie7" style="width: 730px; height: 500px; float: left; margin-left:5px; border:1px solid #DCDCDC">
	<div id="tabs" class="tabs-home-admin-ie7">
        <ul class="ul-tabs-home-admin-ie7">
			<li><a href="#tabs-6" style="margin-left:0px;">New Properties Report </a></li>
			<li><a href="#tabs-1">Page Report</a></li>
			<li><a href="#tabs-2">Banner Report</a></li>
            <li><a href="#tabs-3">Members Report </a></li>
			<li><a href="#tabs-4">Bidding Report</a></li>
			<li><a href="#tabs-5">Properties Sold Report</a></li>
        </ul>

        <div id="tabs-1" style="width:700px; height:445px;"></div>
        <div id="tabs-2" style="width:700px; height:445px;"></div>
        <div id="tabs-3" style="width:700px; height:445px;"></div>
        <div id="tabs-4" style="width:700px; height:445px;"></div>
        <div id="tabs-5" style="width:700px; height:445px;"></div>
        <div id="tabs-6" style="width:700px; height:445px;"></div>
    </div>
</div>