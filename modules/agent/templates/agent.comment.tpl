<script src="/modules/comment/templates/js/comment.js"></script>
<script type="text/javascript">
var commentGrid = new CommentGrid('#frmComment');
</script>

<div class="bar-title">
    <h2>COMMENTS</h2>
</div>

<div class="ma-info mb-20px">
    <div class="col2-set mb-20px">
        <div class="col">
            <div class="col-main myaccount">
            <!--BEGIN-->
				<!--onsubmit="return false;"-->
                <form id="frmComment" name="frmComment"  action = "{$form_action}" method="post" onsubmit="return commentGrid.isSubmit()">
               {if isset($action_ar[0])}
                	{if isset($message) and strlen($message) > 0}
                    	<div class="message-box message-box-comment-ie">{$message}</div>
                    {/if}
               
                    {if in_array($action_ar[0], array('view','delete'))}
                    	{if $comment_id == 0}                
                            <div class="ma-messages mb-20px div-tbl-comment">
                                <table style="border-top: 1px solid #DADADA;
                                border-right: 1px solid #DADADA;border-left: none;border-bottom: none;" class="tbl-comment tbl-messages tbl-messages2" cellpadding="0" cellspacing="0">
                                    <colgroup>
                                        <col width="20px"/><col width="20px"/><col width="310px"/><col width="130px"/><col width="100px"/><col width="50px" />
                                    </colgroup>
                                    <thead>
                                        <tr>
                                             <td>
                                                <input type="checkbox" name="all_chk"  value="" onclick="Common.checkAll(this,'chk')"/>

                                            </td>
                                            <td>
                                                <!--<input type="checkbox" name="all_chk"  value="" onclick="Common.checkAll(this,'chk')"/>-->
                                                Index
                                            </td>
                                            <td>
                                            	Subject
                                            </td>
                                            <td>
                                                Email
                                            </td>
                                            <td>
                                                Created date
                                            </td>
                                            <td>
                                            	Status
                                            </td>

                                        </tr>
                                    </thead>
                                    {if isset($comment_rows) and is_array($comment_rows) and count($comment_rows) > 0}
                                    <tbody>
                                    	
                                        {foreach from = $comment_rows key = k item = row}
                                        <tr  {if $k%2 == 0} class="read" {/if}>
                                            <td align="center">
                                                <input type="checkbox" name="chk[{$row.comment_id}]" id="chk_{$row.comment_id}" value="{$row.comment_id}"/>

                                            </td>
                                            <td align="center">
                                                <!--<input type="checkbox" name="chk[{$row.comment_id}]" id="chk_{$row.comment_id}" value="{$row.comment_id}"/>-->
                                                {$k+1}
                                            </td>
                                            <td onclick="commentGrid.redirect('{$row.link_detail}')">
                                            	{$row.title}
                                            </td>
                                            <td align="center" onclick="commentGrid.redirect('{$row.link_detail}')">
                                            	{$row.email}
                                            </td>
                                            <td align="center" onclick="commentGrid.redirect('{$row.link_detail}')">
                                                {$row.created_date}
                                            </td>
                                            <td align="center">
                                            	{$row.link_status}
                                            </td>
                                            {*
                                            <td onclick="commentGrid.rowdelete('{$row.link_detail}')" align="center" >
                                                Delete
                                            </td>
                                            *}
                                        </tr>
                                        {/foreach}
                                    {else}
                                        <tr>
                                            There is no comment.
                                        </tr>
                                    </tbody>
                                    {/if}
                                    <tfoot style="border: none; display: none;">

                                        <tr>
                                            <td colspan="2" align="right" style="padding-top: 30px">
                                              <a href="javascript:void(0)" onclick="commentGrid.del()">Delete</a>
                                            </td>
                                            {*
                                            <td colspan="1">
                                            	{if strlen($pag_str) > 0}
                                                    {$pag_str}
                                                    <span style="float: right; margin-top: 2px; margin-right:4px; ">Page: </span>
                                                {/if}
                                            </td>
                                            *}
                                        </tr>
                                    </tfoot>
                                </table>
                                <button class="btn-red btn-red-mess-send btn-red-comment" onclick="commentGrid.del()">
                                    <span><span>Delete</span></span><br>
                                </button>
                            </div>
                		{else}
								<div class="ma-messages-read mb-20px">
                                    <div class="form-read">
                                        <div class="form-title">
                                            {$comment_row.title} on {$comment_row.created_date}
                                        </div>
                                        <div class="form-box">
                                        	<p>
												<strong>Content: </strong>{$comment_row.content}
                                        	</p>	
                                        	<p>
												<strong>Name: </strong>{$comment_row.name}										
                                        	</p>	
                                        	<p>
												<strong>Email: </strong>{$comment_row.email}											
                                        	</p>	

                                            <div class="buttons-set-s">
                                                <button class="btn-red btn-red-mess-send btn-red-pending" onclick="commentGrid.redirect('{$comment_row.link_status}')">
                                                <span><span>{$comment_row.label_status}</span></span><br>
                                                </button>
                                                {*<a style="margin-left:5px" href="{$comment_row.link_back}">Back</a>*}
                                                <button class="btn-red btn-red-mess-send btn-red-pending" onclick="commentGrid.del_comment('{$comment_row.link_status_delete}')" style="margin-left: 5px">
                                                <span><span>Delete</span></span><br>
                                                </button>
                                                <button class="btn-red btn-red-mess-send btn-red-pending" onclick="commentGrid.redirect('{$comment_row.link_back}')" style="margin-left: 5px">
                                                <span><span>Back</span></span><br>
                                                </button>
                                            </div>
                                            
                                          
                                        </div>
                                    </div>
                                </div>  
                        {/if}
                    {/if}    
            
                 {/if}
                 <input type="hidden" name="is_submit" id="is_submit" value="0"/>
                </form>            
            <!--END-->
            </div>
        </div>
        <div class="clearthis">
        </div>
    </div>
</div>