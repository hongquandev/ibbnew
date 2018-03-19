<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report</title>
<link href="/modules/general/templates/style/styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/modules/general/templates/js/gos_api.js"></script>
<!--<script src="/modules/general/templates/js/jquery.min.js" type="text/javascript" charset="utf-8"> </script>-->
<script src="/modules/general/templates/js/jquery-1.6.1.js" type="text/javascript" charset="utf-8"></script>
<script src="/modules/general/templates/js/jquery.json-2.2.js" type="text/javascript"></script>
<script src="/modules/general/templates/js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script></head>
{literal}

<script type="text/javascript" charset="utf-8">
$(function(){
		//$("select").uniform();
});
</script>
{/literal}
        
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
    // Run capabilities test
    enhance({
        loadScripts: [
            {src: '/modules/general/templates/charting/js/excanvas.js', iecondition: 'all'},
			'/modules/general/templates/js/jquery.min.js',
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
/*some demo styles*/
body {font-family: Arial, sans-serif;font-size:12px;margin:0px auto;padding:0px;}
.enhanced h2, .enhanced pre { margin: 3em 20px .5em; }
.enhanced pre { width: 50%; overflow: auto; font-size: 1.4em; margin-top: 0; background: #444; padding: 15px; color: #fff; }
.tbl-messages {display:none};
.visualize {margin:0px;padding:0px};
.enhanced_toggleResult {display:none};
	
</style></head>   
{/literal}

<body>
    <div style="width:65%;margin: 0 auto 20px auto;">
    	<form name="frmReport" id="frmReport" method="post" action="{$form_action}" onsubmit="return report.isSubmit()">
        	<span style="float:left;margin-top: 20px;">
				<div class="logo-box">
                    <img src="/modules/general/templates/images/ibb-logo.png" alt="logo iBB" />
                </div>            	
            </span>
            <span style="width:70px;float:right;margin-top:70px;*margin-right: 12px;">
                        <select name="schedule" onChange="report.submit('#frmReport')">
                           {if $action == 'view-report-property-detail'}
                                    {$option_month_str}
                           {else} {$option_view_str}
                           {/if}
                        </select>
            </span>
            <span style="width:50px;float:right;margin-top:70px;font-weight:bold;">
                Select :
            </span>
            <span style="float:right;width:50px;margin-top:70px;">
                <a href="javascript:window.print();">Print</a>
            </span>

            <input type="hidden" name="is_submit" id="is_submit" value="0"/>
        </form>
            <br clear="all"/>
    </div>

    {if $action == 'view-report-property-detail'}

    <table id="chart" style="display:none;width:59%;margin: 0 auto;">
        <caption>{$info}</caption>

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
                <td>300</td>
            </tr>
        {/foreach}
            <tr>
                <th scope="row">Total</th>
                <td></td>
            </tr>
        </tbody>
    </table>
    {else} {* VIEW *}
            <table id="chart" style="display:none;width:59%;margin: 0 auto;">
            <caption>{$info}</caption>

            <thead>
                <tr>
                    <td></td>
                    {$day_str}
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                   <th scope="row">Bid</th>
                   {assign var = key value = view}
                        {foreach from = $data[$key] key = k item = val2}
                                <td>0</td>
                        {/foreach}
                     <td>0</td>
                </tr>
                <tr>
                    <th scope="row">View</th>
                        {assign var = key value = view}
                        {foreach from = $data[$key] key = k item = val2}
                                <td>{$val2}</td>
                        {/foreach}
                        <td>0</td>
                </tr>
                <tr>

                    <th scope="row">Total</th>
                   <td></td>

                </tr>

{*                    {foreach from = $type key = k item = val}*}
{*                     {if $k == view}*}
{*                    <tr>*}
{*                        <th scope="row">{$val}</th>*}
{*                        {foreach from = $data[$k] key = k item = val2}*}
{*                            <td>{$val2}</td>*}
{*                        {/foreach}*}
{*                            <td>300</td>*}
{*                    </tr>*}
{*                    {/if}*}
{*                    <th scope="row"></th>*}
{*                {/foreach}*}
{*                    <tr>*}
{*                        <th scope="row">Total</th>*}
{*                        <td></td>*}
{*                    </tr>*}

        </tbody>
    </table>
    {/if}
</body>
</html>

