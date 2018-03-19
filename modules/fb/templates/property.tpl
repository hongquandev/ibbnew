{literal}
<script type="text/javascript" src="modules/property/templates/js/property.js"></script>
<script type="text/javascript" src="modules/agent/templates/js/loginpopup.js" ></script>
<script type="text/javascript">
	pro = new Property();
	var ids = [];
</script>
{/literal}   
<div id="auction-box" class="auctions-box auctions-box-live-home auctions-box-g">
    <div class="bar-title">
        <h2>Live Auctions</h2>
        <a target="_blank" class="view-more view-all cufon" href="{$ROOTURL}/online-auctions.html">VIEW ALL</a>
        <div class="clearthis"></div>
    </div>
    <div id="sli">
        <div align="center"><img style="height:40px;" src="/modules/general/templates/images/loading.gif" alt="" /></div>
    </div>
    <div class="clearthis"></div>
</div>
<div id="forthcoming-box" class="property-box auctions-box auctions-box-live-home auctions-box-g">
    <div class="bar-title">
        <h2>FORTHCOMING AUCTIONS<a target="_blank" style="float:right;clear:none;" class="view-more view-more-forthcoming" href="{$ROOTURL}/forthcoming-online-auctions.html">VIEW ALL</a></h2>
        <div class="clearthis"></div>
    </div>
    <div id="sli2">
        <div><img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt="" /></div>
    </div>
    <div class="clearthis"></div>
</div>

<div id="sale-box" class="auctions-box auctions-box-live-home auctions-box-g" >
    <div class="bar-title" style="position: relative ;">
        <h2>For Sale</h2>
        <a target="_blank" class="view-more view-all cufon" href="{$ROOTURL}/for-sale.html">VIEW ALL</a>
        <div class="clearthis"></div>
    </div>
    <div id="sli3">
        <div><img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt="" /></div>
    </div>
    <div class="clearthis"></div>
</div>

<div id="loading" style="display:none" align="center"><img style="height:40px;" src="/modules/general/templates/images/loading.gif" alt="" /></div>
{literal}
<script type="text/javascript">
    function stopAllBidTimer(type) {
        stopTimerGlobal();
        for (var i = 0; i < ids.length; i++) {
            if (self['bid_' + ids[i]] /*&& self['bid_' + ids[i]]._options.type == type*/){
                    try{
                        self['bid_' + ids[i]].stopTimer();
                    }catch(err){ }
            }
        }
    }
    var time;
    var array = new Object();
    array.title = ['LIVE AUCTION','FORTHCOMING AUCTIONS','FOR SALE'];
    array.id = ['sli','sli2','sli3'];
    array.action = ['view-auction-list','view-forthcoming-list','view-sale-list'];
    array.type = ['auction','forthcoming','sale'];
    array.por_cur = 0;
    array.box = ['#auction-box','#forthcoming-box','#sale-box'];
    array.lock = false;
	
	
    function loadData(){
		
		if (array.por_cur > 2) array.por_cur = 0;
		
		jQuery('#loading_'+array.type[array.por_cur]).show();
		var url = '/modules/property/action.php?action=home_'+array.type[array.por_cur]+'-property&link_target=_blank&randval='+ Math.random();
		jQuery.post(url,{},function(data){
			if (array.por_cur == 0) {
				stopAllBidTimer();
			}
			
			$(array.box[array.por_cur]).slideDown();
			jQuery('#'+array.id[array.por_cur]).html(data);
			
			array.por_cur++;
			array.lock = false;
			jQuery('#loading').hide();
		},'html');
    }
	
	$(function() {
		loadData();
		setInterval('loadData()', 5000);	
	});
	
</script>
{/literal}

