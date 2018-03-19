{*FOR FOCUS*}

{include file = "`$ROOTPATH`/modules/property/templates/property.home.focus2.tpl"}
{*FOR LIVE*}
{literal}

<script type="text/javascript" src="modules/property/templates/js/property.js"></script> 
<script type="text/javascript" src="modules/agent/templates/js/loginpopup.js" ></script>
<!--
<script src="utils/slide/slide-homeauction.js" type="text/javascript"></script>
<script src="utils/slide/slide-homesale.js" type="text/javascript"></script>
<script src="utils/slide/slide-home-forsale.js" type="text/javascript"></script>
-->
<script src="utils/slide/slide-home.js" type="text/javascript"></script>
<style type="text/css">
.auctions-box .auctions-list .auction-item .auc-info p.name {
    font-size: 11px;
    margin-bottom: 0px !important;
    min-height: 30px;
    padding: 0 5px;
}
</style>
<script type="text/javascript">
	pro = new Property();
	var ids = [];
</script>
{/literal}
        {if isset($is_active) and $is_active == 0}
        <script type="text/javascript">
            showMess('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !');
        </script>
        {/if}
        <div class="auctions-box auctions-box-live-home auctions-box-g" >
            <div class="bar-title">
                <h2>Live Auctions</h2>
                <a class="view-more view-all cufon" href="?module=property&action=view-auction-list">VIEW ALL</a>
                <div class="clearthis"></div>
            </div>
            <div id="sli">
                {*<div name="loading" align="center">*}
                    <div>
                    <img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt="" />
                </div>
            </div>
            <div class="clearthis"></div>
        </div>
        
 		<div class="property-box auctions-box auctions-box-live-home auctions-box-g " >
            <div class="bar-title">
                <h2>FORTHCOMING AUCTIONS<a style="float:right;clear:none;" class="view-more view-more-forthcoming" href="?module=property&action=view-forthcoming-list">VIEW ALL</a></h2>
                <div class="clearthis"></div>
            </div>
            <div id="sli2">
                {*<div name="loading" align="center">*}
                    <div>
                    <img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt="" />
                </div>
            </div>
            <div class="clearthis"></div>
        </div>
        
        <div class="auctions-box auctions-box-live-home auctions-box-g" >
            <div class="bar-title">
                <h2>For Sale</h2>
                <a class="view-more view-all cufon" href="?module=property&action=view-sale-list">VIEW ALL</a>
                <div class="clearthis"></div>
            </div>
            <div id="sli3">
                {*<div name="loading" align="center">*}
                    <div>
                    <img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt="" />
                </div>
            </div>
            <div class="clearthis"></div>
        </div>    
{literal}       
<script type="text/javascript">
    function stopAllBidTimer() {
        stopTimerGlobal();
        for (var i = 0; i < ids.length; i++) {

            try{
                self['bid_' + ids[i]].stopTimer();
            }
            catch(err){ }

        }
    }
	
</script>	
{/literal}

