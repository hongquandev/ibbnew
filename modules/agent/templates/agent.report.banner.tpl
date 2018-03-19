<script type="text/javascript" src="/modules/report/templates/js/report.js"></script>
{literal}
<script type="text/javascript">
    var report = new Report();
</script>
{/literal}
    <link href="/modules/report/templates/style/report.css" type="text/css" />
    <link href="/modules/general/templates/charting/css/basic.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/modules/general/templates/charting/shared/EnhanceJS/enhance.js"></script>
{literal}

<script type="text/javascript">
    enhance({
        loadScripts: [
            {src: '/modules/general/templates/charting/js/excanvas.js', iecondition: 'all'},
            '/modules/general/templates/charting/js/visualize.jQuery.js',
            '/modules/general/templates/charting/js/example-filtering.js'
        ],
        loadStyles: [
            '/modules/general/templates/charting/css/visualize.css',
            '/modules/general/templates/charting/css/visualize-light.css'
        ]
    });

</script>
<style type="text/css">

        /*plugin styles*/
    .visualize { border: 1px solid #888; position: relative; background: #fafafa;}
    .visualize canvas { position: absolute; }
    .visualize ul,.visualize li { margin: 0; padding: 0;}

        /*table title, key elements*/
    .visualize-info { padding: 3px 5px; background: #fafafa; border: 1px solid #888; position: absolute; top: -20px; right: 10px; opacity: .8; }
    .visualize .visualize-title { display: block; color: #333; margin-bottom: 3px;  font-size: 1.1em; }
    .visualize ul.visualize-key { list-style: none;  }
    .visualize ul.visualize-key li { list-style: none; float: left; margin-right: 10px; padding-left: 10px; position: relative;}
    .visualize ul.visualize-key .visualize-key-color { width: 6px; height: 6px; left: 0; position: absolute; top: 50%; margin-top: -3px;  }
    .visualize ul.visualize-key .visualize-key-label { color: #000; }

        /*line,bar, area labels*/
    .visualize-labels-x,.visualize-labels-y { position: absolute; left: 0; top: 0; list-style: none; }
    .visualize-labels-x li, .visualize-labels-y li { position: absolute; bottom: 0;}
    .visualize-labels-x li span.label, .visualize-labels-y li span.label { position: absolute; color: #555f;}
    .visualize-labels-x li span.line, .visualize-labels-y li span.line {  position: absolute; border: 0 solid #ccc; }
    .visualize-labels-x li { height: 100%; }
    .visualize-labels-x li span.label { top: 100%; margin-top: 5px; }
    .visualize-labels-x li span.line { border-left-width: 3px; height: 100%; display: block;}
    .visualize-labels-x li span.line { border: 0;} /*hide vertical lines on area, line, bar*/
    .visualize-labels-y li { width: 100%;  }
    .visualize-labels-y li span.label { right: 100%; margin-right: 5px; display: block; width: 100px; text-align: right;}
    .visualize-labels-y li span.line { border-top-width: 1px; width: 100%;}
    .visualize-bar .visualize-labels-x li span.label { width: 100%; text-align: center; }

        /*IE7 */
    html* .visualize canvas { position: absolute;}
    html* .visualize { margin: 0px 0 0 0px; padding: 70px 40px 90px;background: #ccc; border: 1px solid #ddd;}

        /*visualize extension styles*/
    .visualize {padding: 70px 40px 90px;background: #ccc; border: 1px solid #ddd;margin: 0 auto;*margin-left: 230px !important;/* -moz-border-radius: 12px; -webkit-border-radius: 12px; border-radius: 12px; */}
    .visualize canvas { border: 1px solid #aaa; margin: -1px; background: transparent; z-index:10; }
    .visualize-labels-x, .visualize-labels-y { top: 70px; left: 40px; z-index:1; }

    .visualize-labels-x{ z-index:4; }
    .visualize-labels-y { z-index:2;background: #ffffff; }

    .visualize-pie .visualize-labels { position: absolute; top: 70px; left: 40px; }
    .visualize-labels-x li span.label, .visualize-labels-y li span.label { color: #444; font-size: 1em;}
    .visualize-labels-y li span.line { border-style: solid;  opacity: 1; }
    .visualize .visualize-info { border: 0; position: static;  opacity: 1; background: none; }
    .visualize .visualize-title { position: absolute; top: 20px; color: #333; margin-bottom: 0; left: 20px; font-size: 1.6em; font-weight: bold; }
    .visualize ul.visualize-key { position: absolute; bottom: 15px; background: #eee; z-index: 10; padding: 10px 0; color: #aaa; width: 100%; left: 0;  }
    .visualize ul.visualize-key li { font-size: 1.2em;  margin-left: 20px; padding-left: 18px; }
    .visualize ul.visualize-key .visualize-key-color { width: 10px; height: 10px;  margin-top: -4px; }
    .visualize ul.visualize-key .visualize-key-label { color: #333; }

</style>
{/literal}

<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="myaccount">
                    <div class="bar-title-none" style="font-size: 12px;">
                        <h2>MY BANNER REPORT ID: {$banner_id}</h2>
                    </div>
                    <div class="clearthis"></div>
                    {if $banner.info.display == 1}
                        {assign var = 'display' value = "Right" }
                        {assign var = 'float' value = "float: right;" }
                        {assign var = "width_img" value= "295px" }
                    {else}
                        {assign var = "display" value= "Center" }
                        {assign var = "width_img" value= "616px" }
                        {assign var = "float"  value = "float: left;" }
                    {/if}

                    <div class="banner-detail" style="width: 825px; padding-left: 65px; padding-top: 30px; height: 215px;">
                        <div style="float: left;">
                            <div style=" border: 1px solid #808080;vertical-align: middle;padding: 10px">
                                <a href="{$banner.info.url}" target="_blank">
                                    <img src="{$MEDIAURL}/store/uploads/banner/images/{$banner.info.banner_file}" style="width: {$width_img}; height: auto;" />
                                </a>
                            </div>
                        </div>
                        <div style="padding-top: 15px;{$float}">
                            <div id="search-partner" class="info" >
                                <div class="sub-banner-title" style="font-size: 18px">
                                    <span class="span-a"> {$banner.info.banner_name}  </span>
                                    <span class="span-b"> {$banner.info.creation_time} </span>
                                </div>

                                <div class="clearthis"></div>
                                <div class="sub-partner-all-b">
                                    <div style="color:#980000;"><span>ID</span>: {$banner.info.banner_id}</div>
                                    <div style="color:#980000;"><span>Display</span>: {$display}</div>
                                </div>

                                <div class="clearthis"></div>
                                <div class="sub-partner-all-b">
                                    <div style="color:#980000;"><span> Date From</span>: {$banner.info.date_from} </div>
                                    <div style="color:#980000;"><span> Date To</span>:  {$banner.info.date_to}</div>
                                </div>

                                <div class="clearthis"></div>
                                <div class="sub-partner-all-b">
                                    <div style="float: left;"><span>Url</span>: <a href="{$banner.info.url}" target="_blank">{$banner.info.url} </a> </div>
                                </div>
                                <div class="clearthis"></div>
                                <!-- desc-mycc-ie7-->
                                <div class="sub-partner-all-b">
                                    <span style="font-weight:bold;font-size: 11px"> {$banner.info.full_address} </span>

                                    <div style="float:left">
                                        <span> Type</span>: {$banner.info.type}
                                        <span style="margin-left:5px;"> Click</span>:  {$banner.info.click}
                                        <span style="margin-left:5px;"> Views</span>: {$banner.info.views}
                                    </div>
                                </div>
                                <div class="clearthis"></div>
                                <div class="sub-partner-all-b">
                                    <span style="float:left;">
                                            {$banner.info.suburb} {$banner.info.name} {$banner.info.postcode}
                                    </span>
                                </div>
                                <div class="clearthis"></div>
                                <div class="botton sub-partner-all-b" style="">
                                    <p>
                                        <span style="float:left">Page:</span>
                                        <span style="width:264px;margin-left:5px;float:left">
                                            <select>{html_options options = $banner.info.page_list}</select>
                                        </span>
                                    </p>
                                </div>
                                <div class="clearthis"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clearthis"></div>
                    <div style="height: 25px"></div>
                    <div class="content-banner-report">
                        <div class="title-report" style="border-bottom: 1px solid rgb(128, 128, 128); font-weight: bold; font-size: 13px; padding-bottom: 5px;">
                            Report Banner
                        </div>
                        {*BEGIN MONTHLY REPORT*}
                        <div id="chart-monthly" class="chart-monthly">
                            <div style="padding: 10px 20px 10px 0">
                                <form name="frmReport" id="frmReport" method="post" action="{$form_action}" onsubmit="return report.isSubmit()">

                                    <span style="font-weight:bold;float: left;padding-right: 20px">
                                        Select Report :
                                    </span>
                                    <span style=" float: left;width:80px;">
                                        <select id="type" onChange="change_type_report(this.value)">
                                            {html_options options = $options_type selected= $options_type_def }
                                        </select>
                                    </span>


                                    <div style="padding-left: 10px;display: none;" id="options_year_re">
                                        <span style="font-weight:bold;float: left;padding-left: 35px;padding-right: 20px;">
                                            Select A Year :
                                        </span>
                                        <span style=" float: left;width:80px;">
                                            <select id="options_year" onChange="">
                                            {html_options options = $options_year_banner selected = $options_year_banner_def }
                                            </select>
                                        </span>
                                    </div>


                                    <div class="" style="padding-left: 10px;display: none;" id="options_month_re">
                                        <span style="font-weight:bold;float: left;padding-right: 20px;padding-left: 35px">
                                            Select A Month :
                                        </span>
                                        <span style=" float: left;width:80px;">
                                            <select id="options_month" onChange="">
                                            {html_options options = $options_month_banner}
                                            </select>
                                        </span>
                                    </div>

                                    <p style="float:right; margin-top:0px;">
                                        <a href="javascript:void(0)" id="prt" onclick="window.print();">
                                            <img style="width: 26px;height: 26px;" src="/modules/general/templates/images/Printer-icon.png" style="border:none" />
                                        </a>
                                    </p>

                                    <div class="clearthis"></div>
                                    <button onclick="view_report()" class="btn-red btn-red-my-banner" style="margin-top: 10px; margin-left: 0;">
                                        <span><span>View Report</span></span>
                                    </button>

                                    <input type="hidden" name="is_submit" id="is_submit" value="0"/>
                                </form>
                                <br clear="all"/>
                            </div>
                            <div id="chart-content">
                                <table id="chart" style="width:59%;margin: 0 auto;display: none;">
                                    <caption>{$title_chart}</caption>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            {$day_str}
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach from = $type key = k item = val}
                                            <tr>
                                                <th scope="row">{$val}</th>
                                                {foreach from = $data[$k] key = k item = val2}
                                                    <td>{$val2}</td>
                                                {/foreach}
                                                <td></td>
                                            </tr>
                                        {/foreach}
                                        <tr>
                                            <th scope="row">Total</th>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {*END MONTHLY REPORT*}
                    </div>
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var banner_id = "{$banner_id}";
</script>
{literal}
    <script type="text/javascript">
        function change_type_report(value){
            if( value == 'monthly'){
                jQuery('#options_year_re').show();
                jQuery('#options_month_re').hide();
            }else if(value == 'daily'){
                jQuery('#options_year_re').show();
                jQuery('#options_month_re').show();
            }else if(value == 'yearly'){
                jQuery('#options_year_re').hide();
                jQuery('#options_month_re').hide();
            }
        }
        change_type_report(jQuery('#type').val());
        function view_report(){
            showLoadingPopup();
            par = new Object();
            par.type = jQuery('#type').val();
            par.year = jQuery('#options_year').val();
            par.month = jQuery('#options_month').val();
            var url = '/index.php?module=agent&action=view-report-banner-detail&id='+banner_id;
            jQuery.post(url, par ,function(data){
                closeLoadingPopup();
                jdata = jQuery.parseJSON(data);
                jQuery('#chart-content').html(jdata.html);
                $('#chart').visualize({
                            rowFilter: ':not(:last)',
                            colFilter: ':not(:last-child)'
                        });
                /*window.scrollTo( 400, 500) ;*/
                /*var div = jQuery('#chart-content');*/
                var div = document.getElementById('chart-monthly');
                window.scrollTo(0,findPos(div)-30);
            },'html');
        }

        /*Finds y value of given object*/
        function findPos(obj) {
            var curtop = 0;
            if (obj.offsetParent) {
                do {
                    curtop += obj.offsetTop;
                } while (obj = obj.offsetParent);
                return [curtop];
            }
        }
    </script>

{/literal}
