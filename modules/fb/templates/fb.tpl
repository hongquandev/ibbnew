<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript">
	var ROOTURL = '{$ROOTURL}';
	var FB_SITE = true;
	</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>bidRhino.com</title>
    <link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/general/templates/style/style.php"/>
    <link rel="stylesheet" type="text/css" href="{$ROOTURL}/modules/fb/templates/css/styles.css"/>
	<script type="text/javascript" src="{$ROOTURL}/modules/general/templates/js/javascript.php"></script>
</head>

<body>
    <div class="main">
        <div class="col-main">
            {include file = "`$ROOTPATH`/modules/fb/templates/property.tpl"}
        </div>
        <div class="col-right" style="float:left;margin-left:15px;;width:160px">
        	{include file = "`$ROOTPATH`/modules/fb/templates/search-form.tpl"}
            {include file = "`$ROOTPATH`/modules/fb/templates/banner.tpl"}
        </div>
        <div class="clearthis"></div>
    </div>
    <script type="text/javascript">
    {literal}
		$(function(){
                $("select").uniform();
				$("select").show();
        });
    {/literal}
	</script>
</body>
</html>

