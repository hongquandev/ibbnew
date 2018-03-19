<?php
require '../../configs/config.inc.php';
require ROOTPATH . '/includes/functions.php';
include ROOTPATH . '/includes/model.class.php';
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once 'inc/property.php';
include_once ROOTPATH . '/modules/general/inc/medias.class.php';
include_once ROOTPATH . '/modules/property/inc/property_entity_option.class.php';

if (detectBrowserMobile()) {
    $smarty->compile_dir = ROOTPATH . '/m.templates_c/';
} else {
    $smarty->compile_dir = ROOTPATH . '/templates_c/';
}
include_once ROOTPATH . '/modules/configuration/inc/config.class.php';
if (!isset($config_cls) || !($config_cls instanceof Config)) {
    $config_cls = new Config();
}
if (!isset($media_cls) or !($media_cls instanceof Medias)) {
    $media_cls = new Medias();
}
$auction_sale_ar = PEO_getAuctionSale();
$id = (int)($_GET['id'] ? $_GET['id'] : 0);
$id = restrictArgs($id, '[^0-9a-zA-Z\-]');
$_imageAr = array();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="<?php echo ROOTURL; ?>/modules/general/templates/style/styles.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo ROOTURL; ?>/modules/property/templates/style/styles.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo ROOTURL; ?>/modules/property/templates/js/print.js"></script>
</head>
<body>
<div style="margin-left:40px">
    <?php
    $media_row = array();
    if (isset($id)) :
    //$data = Property_getDetail($id);
    //print_r($data);
    $agentInfo = A_getCompanyInfo($id);

    $sql = 'SELECT  pro.*,
				(SELECT reg1.name FROM ' . $region_cls->getTable() . ' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
				(SELECT reg2.code FROM ' . $region_cls->getTable() . ' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
				(SELECT reg3.name FROM ' . $region_cls->getTable() . ' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
				(SELECT reg4.code FROM ' . $region_cls->getTable() . ' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,
				
				(SELECT med.file_name
					FROM ' . $property_media_cls->getTable('medias') . ' AS med,' . $property_media_cls->getTable() . ' AS pro_med
					WHERE med.media_id = pro_med.media_id AND med.type = \'photo\' AND pro_med.property_id = \'' . $id . '\' LIMIT 1) AS file_name
			FROM ' . $property_cls->getTable() . ' AS pro
			WHERE pro.property_id = ' . $id;
    $row = $property_cls->getRow($sql, true);
    //echo $property_cls->sql;
    if (is_array($row) and count($row) > 0) :
    $_photo = PM_getPhoto($row['property_id']);
    $_imageAr = $_photo['photo'];
    $row['photo_default'] = $_photo['photo_default'];
    $row['file_name'] = ROOTURL . '/' . trim($row['photo_default'], '/');
    $row['address'] = $row['address'] . ', ' . $row['suburb'] . ', ' . $row['state_name'] . ', ' . $row['postcode'] . ', ' . $row['country_name'];

    ?>
    <div style="float:left; margin-bottom:0px; width:100%">
        <?php
        if (strlen(trim(@$agentInfo['logo'])) > 0) :
            ?>
            <img src="<?php echo ROOTURL; ?>/<?php echo @$agentInfo['logo']; ?>" style="border:none" height="80"/>
        <?php
        else :
            ?>
            <img src="<?php echo ROOTURL; ?>/modules/general/templates/images/logo.jpg" style="border:none" />
        <?php
        endif;
        ?>
    </div>
    <p style="float:right;display:none">
        <a href="javascript:void(0)" id="prt" onclick="return prints();">
            <img src="<?php echo ROOTURL; ?>/modules/general/templates/images/Printer-icon.png" style="border:none"/>
        </a>
    </p>

    <div class="col-main" style="margin-left:0px;width:auto">
        <div class="property-box" id="property-box-d">
            <div class="property-detail">
                <div class="detail-2col">
                    <div class="col1 f-left">
                        <div>Property Id: <?php echo $row['property_id']?></div>
                        <div><p class="address" style="padding-left:0px;font-size:16px"><?php echo $row['address']; ?></p></div>
                        <div class="detail-imgs" style="margin:0px">
                            <img id="photo_main" src="<?php echo $row['file_name']; ?>"
                                 alt="Photo"
                                 class="p-watermark-detail-big" />
                            <?php
                            /*
                            if (count($_imageAr) > 0) :
                            ?>
                               <div class="img-list-box" id="img-list-box" style="margin-top:4px">
                                   <div class="img-prev"><span class="icons"></span></div>
                                   <div class="img-list" style="width:372px;height:93px;overflow:hidden;float:left">
                                       <div id="img-list-slide">
                                               <?php
                                            foreach ($_imageAr as $_row) :
                                            ?>
                                               <div class="item">
                                                   <a><img src="<?php echo $_row['file_name'];?>" onmouseover="img(this)" alt="photos" style="width:123px;height:93px"/></a>
                                               </div>
                                           <?php
                                           endforeach;
                                           ?>
                                       </div>
                                   </div>
                                   <div class="img-next"><span class="icons"></span></div>
                                   <div class="clearthis"></div>
                               </div>
                               <script type="text/javascript">SlideShow.init('#img-list-box', '#photo_main')</script>
                            <?php
                            endif;
                            */
                            ?>
                        </div>

                        <div class="property-desc" style="margin-top:10px; width:600px">
                            <h2>PROPERTY DESCRIPTION</h2>

                            <div>
                                <p><?php echo strlen($row['description']) > 500 ? substr($row['description'], 0, 500) . ' ...' : $row['description']; ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            endif;
            endif;
            ?>
        </div>
</body>
</html>
<script>
    //window.print();
</script>