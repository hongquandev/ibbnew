 <div style="float: left; width: 240px; height:500px;" class="leftdash">
   <div class="report-search">
      <div class="f-left">
           <span>From</span><input type="text" id="from" name="from" class="input-text"/></br>
           <span style="margin-right:14px;">To</span><input type="text" id="to" name="to" class="input-text"/>
      </div>
      <div class="f-right">
           <input type="button" value="Search" class="button" style="width:65px;" onclick="search()"/>
      </div>
   </div>
   <div class="clearthis"></div>
   <div class="report">
   {*NEW*}
    <table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
       <tr>
           <th colspan="3" class="top">
                <span style="font-weight: bold !important;">New Property Today</span>
           </th>
       </tr>

       <tr>
           <th width="50%"><span>Description</span></th>
           <th><span>Property number</span></th>
       </tr>

       <tr>
           <td colspan="3">
                 {foreach from = $property_new key = k1 item = col}
                                        <div class="row">
                                           <span style="float: left;margin-right: 19px;margin-left:0px !important;">{$col.name}</span>
                                            <span>{$col.number}</span>
                                            <div class="clr"></div>
                                        </div>
                 {/foreach}
           </td>
       </tr>
    </table>

               {*SOLD*}
               <table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                          <th colspan="3" class="top">
                             <span style="font-weight: bold !important;">Property Sold Today</span>
                          </th>
                      </tr>

                      <tr>
                          <th width="50%">
                              <span>Description</span>
                          </th>
                          <th>
                              <span>Property number</span>
                          </th>
                      </tr>

                      <tr>
                          <td colspan="3">
                             {foreach from = $property_sold key = k1 item = col}
                                 <div class="row">
                                    <span style="float: left;margin-right: 19px;margin-left:0px !important;">{$col.name}</span>
                                    <span>{$col.number}</span>
                                    <div class="clr"></div>
                                 </div>
                              {/foreach}
                           </td>
                      </tr>
               </table>


               {*PACKAGE*}
               <table style="margin: 6px;" width="95%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                          <th colspan="3" class="top">
                             <span style="font-weight: bold !important;">Property's packages Today</span>
                          </th>
                      </tr>

                      <tr>
                          <th width="50%">
                              <span>Package</span>
                          </th>
                          <th>
                              <span>Property number</span>
                          </th>
                      </tr>

                      <tr>
                          <td colspan="3">
                             {foreach from = $property_package key = k1 item = col}
                                 <div class="row">
                                    <span style="float: left;margin-right: 19px;margin-left:0px !important;">{$col.name}</span>
                                    <span>{$col.number}</span>
                                    <div class="clr"></div>
                                 </div>
                              {/foreach}
                           </td>
                      </tr>
               </table>
    </div>
</div>
<script type="text/javascript">
    var token = '{$token}';
    {literal}

         Calendar.setup({
            inputField : 'from',
            trigger    : 'from',
            onSelect   : function() { this.hide() },
            showTime   : true,
            dateFormat : "%Y-%m-%d"
        });

        Calendar.setup({
            inputField : 'to',
            trigger    : 'to',
            onSelect   : function() { this.hide() },
            showTime   : true,
            dateFormat : "%Y-%m-%d"
        });
        function search(){
            var date_from = $('#from').val();
            var date_to = $('#to').val();
            var url = '../modules/report/action.admin.php?action=search-property&token='+token;
            $.post(url,{date_from:date_from,date_to:date_to},function(data){
                            $('div.report').html(data);
                        },'html');
        }
    {/literal}
</script>