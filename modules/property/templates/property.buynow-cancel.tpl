{literal}
<style type="text/css">
    .property-buynow{
        border: 1px solid #980000;
        padding: 20px 10px;
        font-size: 14px;
        color: #980000;
        margin-bottom: 30px;
    }
</style>
{/literal}

<div class="container-l">
    <div class="container-r">
        <div class="container col1-layout">
            <div class="col-main property-buynow">
                You have canceled buy now with Property ID# {$property_id}
                <br>
                You will be redirected to the Homepage in 5s.
            </div>
        </div>
    </div>
</div>
{literal}
<script type="application/javascript">
    setTimeout(function(){
        document.location = ROOTURL;
    },5000)
</script>
{/literal}