<link rel="stylesheet" type="text/css" media="screen" href="/modules/general/templates/js/codaslider/css/coda-slider.css">
<script src="/modules/general/templates/js/codaslider/js/jquery-easing.1.2.js" type='text/javascript'></script>
<script src="/modules/general/templates/js/codaslider/js/jquery-easing-compatibility.1.2.js" type='text/javascript'></script>
{literal}
<script type="text/javascript">
    $(function() {
        $('#blogSlider').codaSlider();
    });
    jQuery(document).ready(function() {
        $('.des').bind('click', function() {
            $('.full').toggle();
            $('.short').toggle();
        });
    });
</script>
{/literal}
{literal}
<style type="text/css">
    .make-an-offer-popup{top:0px}
    .make-an-offer-popup .title{margin-left:0px}
    .make-an-offer-popup .title h2{border:0px}
    .g-list-box-ie p{margin-bottom:0px}
    .property-box .bar-title{margin-top:0px !important}
    .span-user-detail{margin-bottom:10px}
    .buttons-set{text-align: left}
</style>
{/literal}
<script type="text/javascript" src="/modules/general/templates/js/jcarousellite_1.0.1.min.js"></script>
<div class="property-box" {*id="property-box-d"*}>
    {*<div class="bar-title">
        <h2>{$title}</h2>
    </div>*}
    <div class="user-detail">
       {* {include file = "agent.detail.`$action_ar[2]`.tpl"}*}
    </div>
    <div class="property-box" style="width: 100%;">
    {*<h2>RECENTLY ADDED PROPERTIES</h2>*}
    {include file="`$ROOTPATH`/modules/agent/templates/mobile/agent.detail.property.tpl"}
</div>
</div>


