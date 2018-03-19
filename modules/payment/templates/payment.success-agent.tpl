<div class="">
    <div class="">
        <div class="">
            <div class="main" style="width: 915px;">
                <div class="col-main" style="float: left; width: 620px;">
                    <div class="step-8-info">
                        <div class="step-name">
                            {if $type == 'registration'}
                                 <h2>Your registration has completed !</h2>
                            {else}
                                <h2>Your payment is successful !</h2>
                            {/if}
                        </div>
                        <div class="step-detail col2-set">
                            <div class="col-1">
                                <p style="">
                                    Thanks for using eBidda.</br>
                                    If you have any issues or concerns please contact us at <a href="mailto:{$contact_email}" style="font-size: 14px;font-weight: bold;">{$contact_email}</a>.
                                </p>
                                <br/>
                                <p>
                                </p>
                            </div>
                            {$meta_refresh}
                            {*<div class="col-2 bg-f7f7f7">
                                <div>
                                    <ul style="margin-left: 50px; height: 100px;">
                                        <li  style="font-size: larger; margin-bottom: 5px;" ><a href="/?module=agent&action=view-dashboard">Go to dashboard.</a></li>
                                    </ul>
                                    {**}
                                {*</div>

                            </div>*}

                            <div class="clearthis"></div>
                        </div>
                    </div>
                </div>

                <div class="col-right">
                      {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>

                <div class="clearthis"></div>
            </div>
        </div>
    </div>
</div>
