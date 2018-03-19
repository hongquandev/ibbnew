<div id="finished-register" class="container-l">
    <div class="container-r">
        <div class="container">
            <div class="main">
                <div class="user-register">
                    <h2>Your registration is completed!</h2>
                    {*<div class="ureg-panel">

                    </div>*}
                    <div class="step-info step-info-regis-success">
                        {$message}
                    </div>
                </div> 
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function(){
              jQuery('#finished-register').css('height', window.screen.height-80);
              
         });
    </script>
{/literal}