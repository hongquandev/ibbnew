<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>{$property_data.info.address_full}</title>
    <link rel="stylesheet" type="text/css" href="/modules/general/templates/style/detail-print.css"/>
    {literal}
        <style type="text/css">
            .header-print {margin: 0 auto;text-align: center;}
            .detail-link {text-align: center;font-weight: bold;color: #3dbff0;}
            .content-print .row1-left { width: 100%; max-width: 403px;}
            .content-print .row1-right { width:100%; max-width: 140px;}
            .content-print .row2-left { width: 100%; max-width: 403px;}
            .content-print .row2-right { width:100%; max-width: 150px;}
            .content-print .id-label{ font-weight: bold;color: #febf32;}
            .content-print .id-value{ font-weight: bold;color: #3d464f;}
            .content-print .price-label{ font-weight: bold;color: #febf32;}
            .content-print .price-value{ font-weight: bold;color: #3d464f;}
            .content-print .address{font-weight: bold;color: #3d464f;}
            .content-print .desc-label{font-weight: bold;color: #3d464f;}
            .img-list-box { margin-top: 15px;}
            .img-list-box img{ margin-right: 7px; margin-bottom: 5px}
            .img-list-box img:nth-child(2n){ margin-right: 0;}
            .row2-left{}
            .row2-right{position: relative;background: url("/modules/general/templates/images/print/icon-right-print.jpg") 0 0 no-repeat }
            .img-bg-icon { z-index: -9999; position:absolute}
            .text-icon{
                padding-right: 15px;
                padding-left: 3px;
                width: 140px;
            }
            .text-left { float: left; font-weight: bold}
            .text-right { float: right; font-weight: bold}
            .text-icon span {font-weight: bold}
            .bedrooms-icon {margin-top: 50px}
            .bathrooms-icon {margin-top: 40px}
            .car-spaces-icon {margin-top: 45px}
            .land-size-icon {margin-top: 40px}
            .land-size-icon .text-right {margin-right: -3px}
            .text-bottom {margin-top: 60px;margin-left: 3px;font-size:13px;color: #8c8e90}
        </style>
    {/literal}
</head>
<body>
<div class="wrapper-print">
    <div class="print-page">
        <div class="header-print" {if $bg_data && $bg_data.top_background != ''} style="background-color: {$bg_data.top_background}"{/if}>
            {if $bg_data and count($bg_data) > 0 and $bg_data.top != ''}
                <a href="?module=agent&action=view-detail-agency&uid={$bg_data.agent_id}">
                    <img src="{$bg_data.top}" alt="logo" title="House and Rural Properties for sale or purchase Australia wide"/>
                </a>
            {else}
                <div class="logo-box">
                    <a href="{$ROOTURL}"><img src="{$MEDIAURL}/modules/general/templates/images/print/logo.jpg" alt="logo"/></a>
                </div>
            {/if}
        </div>
        <div class="col-main">
            <div class="content-print">
                <br>
                <div class="detail-link">{$property_data.info.link}</div>
                <br>
                <br>
                <div class="row1-left f-left" style="width: 403px; max-width: 403px;">
                    <span class="id-label">Property ID: </span><span class="id-value">{$property_data.info.property_id}</span>
                    <br>
                    <span class="price-label">Price:</span>
                    <span class="price-value">
                       <span id="price-{$property_data.info.property_id}">{$property_data.info.price}</span>
                        {if in_array($property_data.info.pro_type_code,array('ebiddar','bid2stay'))}
                            <span class="period">{$property_data.info.period}</span>
                        {/if}
                    </span>
                    <br>
                    <br>
                    <div class="address">
                        {$property_data.info.address_full}
                    </div>

                </div>
                <div class="row1-right f-right" style="width:140px; max-width: 140px;">
                    <div class="qr-code">
                        <img src="{$ROOTURL}/phpqrcode/qrcode.php?size=3&data={$property_data.info.link}" title="QR-code" alt="QR-code" />
                    </div>
                </div>
                <div class="clearthis"></div>
                <br>
                <div class="row2-left f-left" style="width: 403px; max-width: 403px;">
                    <div class="detail-imgs">
                        {if isset($property_data.photo_default)}
                            <div class="img-main">
                                <img id="photo_main" src="{$MEDIAURL}/{$property_data.photo_default}" alt="Photo" width="402" height="243" />
                            </div>
                        {/if}
                        {*End Photo Main *}
                        {*Begin Photo Slide*}
                        {if isset($property_data.photo) and is_array($property_data.photo) and count($property_data.photo)>0}
                        {*{if true}*}
                            <div class="img-list-box" id="img-list-box">
                                <div class="img-list">
                                    <div id="img-list-slide">
                                        {foreach from = $property_data.photo key = k item = row}
                                            {if $row.file_name == $property_data.photo_default}
                                            {elseif $k <=3 }
                                                <img src="{$MEDIAURL}/{$row.file_name}" alt="photos" width="196" height="117"/>
                                            {/if}
                                        {/foreach}
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                            </div>
                        {/if}
                    </div>
                    <br>
                    <div class="desc-label">PROPERTY DESCRIPTION</div>
                    <div class="desc-value">{$property_data.info.print_description}</div>
                </div>
                <div class="row2-right f-right" style="width:140px; max-width: 140px;">
                    {*<div class="img-bg-icon">
                        <img src="/modules/general/templates/images/print/icon-right.jpg" alt="bg" width="151" height="385" />
                    </div>*}
                    <div class="text-icon">
                        <div class="bedrooms-icon">
                            <span>Bedrooms &nbsp;</span><span>{if $property_data.info.bedroom_value > 0}{$property_data.info.bedroom_value}{else} N/A{/if}</span>
                            {*<div class="text-left">Bedrooms</div>
                            <div class="text-right">{if $property_data.info.bedroom_value > 0}{$property_data.info.bedroom_value}{else} N/A{/if}</div>*}
                        </div>
                        <div class="clearthis"></div>
                        <div class="bathrooms-icon">
                            <span>Bathrooms &nbsp;</span><span>{if $property_data.info.bathroom_value > 0 }{$property_data.info.bathroom_value} {else} N/A{/if}</span>
                            {*<div class="text-left">Bathrooms</div>
                            <div class="text-right">{if $property_data.info.bathroom_value > 0 }{$property_data.info.bathroom_value} {else} N/A{/if}</div>*}
                        </div>
                        <div class="clearthis"></div>
                        <div class="car-spaces-icon">
                            <span>Car Spaces &nbsp;</span><span>{if $property_data.info.parking == 1}{$property_data.info.carport_value}{else} N/A{/if}</span>
                            {*<div class="text-left">Car Spaces</div>
                            <div class="text-right">{if $property_data.info.parking == 1}{$property_data.info.carport_value}{else} N/A{/if}</div>*}
                        </div>
                        <div class="clearthis"></div>
                        <div class="land-size-icon">
                            <span>Land Size &nbsp;</span><span>{if $property_data.info.landsize !="" }{$property_data.info.landsize}{else} N/A{/if}</span>
                            {*<div class="text-left">Land Size (Metre)</div>
                            <div class="text-right">{if $property_data.info.landsize !="" }{$property_data.info.landsize}{else} N/A{/if}</div>*}
                        </div>
                    </div>
                    <div class="clearthis"></div>
                    <div class="text-bottom">
                        At BidRhino.com its your choice.
                        Buy or rent from anywhere, anytime
                        Make an offer, buy/rent it now, or bid in an online auction
                        transparent, trustworthy and fair
                        For more information visit us today <span>www.bidRhino.com</span>
                    </div>
                </div>
                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">//window.print();</script>
</body>
</html>