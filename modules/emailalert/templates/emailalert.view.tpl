<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
                <div class="col-main">
          	     {if in_array($action,array('add-email','edit-email'))}
					{include file = 'emailalert.add.tpl'}     
                 {/if}          
{*                 {if $action == 'edit-email'}*}
{*                	{include file = 'emailalert.edit.tpl'} *}
{*                 {/if}*}
                </div>
                <div class="col-right">         
                	{include file = "`$ROOTPATH`/modules/agent/templates/agent.side.right.tpl"}
                	{include file = "`$ROOTPATH`/modules/general/templates/side.right.tpl"}
                </div>
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
