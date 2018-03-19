{literal}
<style type="text/css">
    .form-list{
        margin: 5px 0px;
        float: right;
        width: 95%;
        padding: 10px;
    }
    span.head{
        margin-bottom: 2px;
        display: inline-block;
        font-weight: bold;
        font-style: normal;
        margin-top: 4px;
    }
    .content{
        padding: 0 10px 10px;
        font-size:11px
    }

</style>
{/literal}
<div style="display:block;*width:400px">
<div class="title">
    <h2 id="nh_txt">{$site_title_config} say:<span id="btnclosex" class="btnclosex-popup-newsletter" onclick="check_sub.closePopup(true)">x</span></h2>
</div>
<div class="content normal-width">
      <form name="frmSub" id="frmSub" onsubmit="return false;">
          <div class="message-box  message-box-ie" id="message" style="display:none"></div>
          <span class="head">Your account is only created {$package_arr.account_num} sub account(s).</span><br />
          <i>Please INACTIVE at least {$at_least} account(s). Unless we'll inactive your sub-accounts automatically. Thanks you!</i>
              <ul class="form-list">
                  {foreach from=$data item=sub}
                    <li><input type="checkbox" name="sub[]" value="{$sub.agent_id}" {if $sub.is_active == 0}disabled checked="checked"{/if}/> {$sub.firstname} {$sub.lastname}</li>
                  {/foreach}
              </ul>
              <input type="hidden" name="min" id="min" value="{$at_least}"/>
      </form>
      <div class="button-pop-newsletter-customize">
        <button class="btn-red f-right" name="cancel" id="cancel" onclick="check_sub.closePopup(true)"><span><span>Auto Inactive Accounts</span></span></button>
        <button style="margin-right:10px" class="btn-red btn-width f-right" name="submit" id="submit" onclick="check_sub.save()"><span><span>Submit</span></span</button>
      </div>
</div>
</div>
