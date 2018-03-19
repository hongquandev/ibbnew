{*FOR FOCUS*}
{include file = "`$ROOTPATH`/modules/property/templates/property.home.focus.tpl"}
{*FOR LIVE*}
{literal}
<script type="text/javascript" src="modules/general/templates/js/term.popup.js"></script>
<script type="text/javascript" src="modules/property/templates/js/property.js"></script>
<script type="text/javascript" src="modules/agent/templates/js/loginpopup.js" ></script>
<script src="utils/slide/slide-home.js" type="text/javascript"></script>

<script type="text/javascript">
	pro = new Property();
	var ids = [];
</script>
{/literal}
    {if isset($is_active) and $is_active == 0}
        {literal}
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    showMess('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !');
                })
            </script>
        {/literal}
    {/if}
    <div id="auctions-box" class="auctions-box auctions-box-live-home auctions-box-g">
        <div class="bar-title" id="bar-title-auction">
            <h2>LIVE AUCTIONS</h2>
            <a class="view-more view-all cufon" href="{$ROOTURL}/online-auctions.html">VIEW ALL</a>
            <div class="clearthis"></div>
        </div>
        <div id="sli">
            <div align="center">
                <img style="height:40px;" src="/modules/general/templates/images/loading.gif" alt=""/>
            </div>
        </div>
        <div class="clearthis"></div>
    </div>
    <div id="forthcoming-box" class="property-box auctions-box auctions-box-live-home auctions-box-g " style="display:none;">
        <div class="bar-title" style="margin-top: 0;">
            <h2>FORTHCOMING AUCTIONS<a style="float:right;clear:none;" class="view-more view-more-forthcoming"
                                       href="{$ROOTURL}/forthcoming-online-auctions.html">VIEW ALL</a></h2>

            <div class="clearthis"></div>
        </div>
        <div id="sli2">
            <div>
                <img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt=""/>
            </div>
        </div>
        <div class="clearthis"></div>
    </div>
    <div id="sale-box" class="auctions-box auctions-box-live-home auctions-box-g" style="display:none">
        <div class="bar-title" style="position: relative ;">
            <h2>For Sale</h2>
            <a class="view-more view-all cufon" href="{$ROOTURL}/for-sale.html">VIEW ALL</a>
            <div class="clearthis"></div>
        </div>
        <div id="sli3">
            <div>
                <img style="height:30px;" src="/modules/general/templates/images/loading.gif" alt=""/>
            </div>
        </div>
        <div class="clearthis"></div>
    </div>
    <div id="loading" style="display:none" align="center">
        <img style="height:40px;" src="/modules/general/templates/images/loading.gif" alt=""/>
    </div>
{literal}
<script type="text/javascript">
    function stopAllBidTimer(type) {
        stopTimerGlobal();
        for (var i = 0; i < ids.length; i++) {
            if (self['bid_' + ids[i]] && self['bid_' + ids[i]]._options.type == type){
                    try{
                        self['bid_' + ids[i]].stopTimer();
                    }catch(err){ }
            }
        }
    }
    var time;
    var array = new Object();
    array.title = ['FORTHCOMING AUCTIONS','For Sale'];
    array.id = ['sli2','sli3'];
    array.action = ['view-forthcoming-list','view-sale-list'];
    array.type = ['forthcoming','sale'];
    array.por_cur = 0;
    array.box = ['#forthcoming-box','#sale-box'];
    array.lock = false;
    $(function() {
        $(window).bind('scroll',function(){
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 350 && array.por_cur < 2 && !array.lock){
                jQuery('#loading').show();
                array.lock = true;
                loadData();
            }
        });
    });
    function loadData() {
        var data_ = null;
        if(typeof array.type[array.por_cur] == 'undefined' )
        {
            array.por_cur = 0;
        }
        jQuery('#loading_' + array.type[array.por_cur]).show();
        var url = '/modules/property/action.php?action=home_' + array.type[array.por_cur] + '-property&ref=lazy& randval=' + Math.random();
        jQuery.post(url, {}, function (data) {
            data_ = data;
            try{
                //data = data.trim();
                data = data.replace(/^\s+|\s+$/g, '');
            }catch (er){}
            /*console.log(typeof data);console.log(data.length);*/
            if (typeof data == 'undefined' || data.length <= 0 || data == '' || data == null ) {
                $(array.box[array.por_cur]).hide();
                /*console.log(array.box[array.por_cur]);*/
            } else {
                $(array.box[array.por_cur]).slideDown();
                jQuery('#' + array.id[array.por_cur]).html(data);
            }
            array.por_cur++;
            array.lock = false;
            jQuery('#loading').hide();
        }, 'html');
        return data_;
    }
</script>
{/literal}

