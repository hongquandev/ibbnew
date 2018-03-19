
{literal}
    <script type="text/javascript">
         function re_url(link)
            {
               document.location = link;
            }
    </script>
{/literal}


<div class="bid-history-full" style="margin-left: 10px;margin-top: 10px;">
    <div class="bar-title">
        <h2>AUCTION BID HISTORY ID: {$property_id}</h2>
        <div style="float: right; margin-bottom: 10px;margin-right: 10px;font-weight: bold;">{$review_pagging}</div>
        
        <div style="float:right;margin-left:4px">
            <form name='frmGoto' id='frmGoto' method="post" action="{$form_action}">
                <div style="width:120px;float:left">
                    <select name="order_by" onchange="jQuery('#frmGoto').submit()" style="display:none">
                        {html_options options=$Bids_order_by selected =$order_by}
                    </select>
                </div>
            </form>
        </div>


    </div>
    <div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
            <!--BEGIN-->
                    {if $show_info }
                            <div class="ma-messages mb-20px div-tbl-comment">
                                <table style="border-top: 1px solid #DADADA;
                                border-right: 1px solid #DADADA;border-left: none;border-bottom: none;" class="tbl-comment tbl-messages tbl-messages2" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col width="20px"/>
                                        <col width="275px"/>
                                        <col width="150px"/>
                                        <col width="143px"/>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                             {*<td>
                                                <input type="checkbox" name="all_chk"  value="" onclick="Common.checkAll(this,'chk')"/>

                                            </td>*}
                                            <td align="center">
                                                Index
                                            </td>
                                            <td align="center" >
                                            	Bidder
                                            </td>
                                            <td align="center">
                                                Price
                                            </td>
                                            <td align="center">
                                                Bid Time
                                            </td>

                                        </tr>
                                    </thead>
                                    {if isset($rows) and is_array($rows) and count($rows) > 0}
                                    <tbody>
                                    	
                                        {foreach from = $rows key = k item = row}
                                            <tr  {if $k%2 == 0} class="read" {/if}>
                                                {*<td align="center">
                                                    <input type="checkbox" name="chk[{$row.comment_id}]" id="chk_{$row.comment_id}" value="{$row.comment_id}"/>
                                                </td>*}
                                                <td align="center">
                                                    {$k+1+$index}
                                                </td>
                                                <td align="center">
                                                    {$row.name}
                                                </td>
                                                <td align="center">
                                                    {$row.price}
                                                </td>
                                                <td align="center">
                                                    {$row.time}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    {else}
                                        <tr>
                                            There is no data.
                                        </tr>
                                    </tbody>
                                    {/if}
                                    <tfoot style="border: none; display: none;">
                                    </tfoot>
                                </table>
                                <div class="div-btn-bid-history-all">
                                    <button class="btn-red btn-red-bid-history-all" onclick="document.location='{$link_detail}'">
                                        <span><span>Back to property detail</span></span><br>
                                    </button>
                                    {* <button class="btn-red btn-red-mess-send btn-red-comment" onclick="document.location='{$link_detail}&track=sw'">
                                        <span><span>switched bids history </span></span><br>
                                     </button>*}
                                </div>
                            </div>
                    {else}
                        <div class="message-box message-box-comment-ie">Lock</div>
                    {/if}
            <!--END-->
                {*FOR PAGGING*}
                <div class="clearthis"></div>
                <div style="border-bottom: 1px dashed; margin-bottom: 10px; margin-top: 20px;"></div>
                {$pag_str}
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>
</div>
