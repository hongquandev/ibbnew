<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main" style="min-height: 250px">
                <div class="col-main user-register">
                    <h1>Your registration is completed!</h1>
                    {*<div class="ureg-panel">
                    </div>*}
                    <div class="step-info step-info-regis-success">
                        {$message}
                        <p style="color:#980000;">
                            Please also check your junk email folder for the registration email or add @bidRhino.com to
                            your trusted email list
                        </p>
                    </div>
                    {*{if (isset($register_property_url) && strlen($register_property_url))}
                         <div class="buttons-set" style="padding-right:0">
                             <button class="btn-blue" onclick="document.location='{$register_property_url}'">
                                 <span><span>Click here to continue register property</span></span>
                             </button>
                         </div>
                    {/if}*}
                </div>
                <div class="col-right">
                    {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    showMess('Thank you for registering as a bidRhino user, you will very shortly receive an email to verify your email address and enable your account, please be sure to check your junk mail folder just in case the email goes there.');
</script>