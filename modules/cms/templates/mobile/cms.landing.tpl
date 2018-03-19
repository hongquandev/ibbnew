{if $landing == "landing"}
<div class="container-l">
    <div class="container-r">
        <div class="container {*col2-right-layout*}">
            <div class="main">
                <div class="user-register-landing" id="user-register-landing">
                    <h1>REGISTER</h1>
                    {if $data}
                        {foreach from=$data item=row}
                            <div class="div-cms-landing-main">
                                <div class="div-cms-landing-top">
                                    <span class="cufon-cms-landing-child">{$row.title}</span>
                                </div>
                                <div class="div-cms-landing">
                                    {$row.content}
                                    <div class="clearthis"></div>
                                    <div class="buttons-set">
                                        <button class="btn-blue"
                                                onclick="document.location='index.php?module=agent&action=register-{$row.key}'">
                                            <span><span>Register</span></span>
                                        </button>
                                    </div>
                                    <!-- End Vendor -->
                                </div>
                            </div>
                            <div class="clearthis"></div>
                        {/foreach}
                    {/if}
            
         </div> <!-- End Colum Left -->
         {*<div class="col-right">
       		    {include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
         </div>*} <!-- End Div Class Col Right -->
                <div class="clearthis">
                </div>
            </div>
         </div>
       </div>
  </div> 
 {/if}