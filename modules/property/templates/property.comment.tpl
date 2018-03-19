 <script type="text/javascript" src="/modules/comment/templates/js/comment.js"></script>
 <script type="text/javascript">
	var com = new Comment('#frmComment','your-say-list');
    com.view('/modules/comment/action.php?action=view-comment&property_id={$property_data.info.property_id}');
    {literal}
   /* $(document).ready(function(){

    });*/
    function clear_txt(obj,txt)
    {
        if(obj.value == txt)
        {
            jQuery(obj).val('');
            obj.value = '';
        }
    }
    {/literal}
 </script>
 <div class="have-your-say-box">
    <div class="title">
        <h2>HAVE YOUR SAY</h2>
        <a href="javascript:void(0)" onclick="jQuery('#comment_form').toggle()">ADD YOUR REVIEW &raquo;</a>
    </div>

    <div class="form-say" id="comment_form" style="display:none">
        <div class="form-title">
        </div>
        <div class="form-box">
            <form id="frmComment" name="frmComment">
            <ul class="form-list">
                    <li>
                        <input type="text" onclick="clear_txt(this,'Name');" id="name" name="name" class="input-text" value="Name" />
                    </li>
                    <li>
                        <input type="text"  onclick="clear_txt(this,'Email');" id="email" name="email" class="input-text validate-email" value="Email" />
                    </li>
                    <li>
                        <input type="text" onclick="clear_txt(this,'Title');" id="title" name="title" class="input-text" value="Title" />
                    </li>
                    <li>
                        <textarea id="content" onclick="clear_txt(this,'Comment');" name="content" class="input-textarea">Comment</textarea>
                        <input type="hidden" id="property_id" name="property_id" value="{$property_data.info.property_id}"/>
                    </li>
            </ul>
            </form>
            <div class="buttons-set-s">


                <button class="btn-red" onclick="com.submit()">
                    <span><span>Submit</span></span>
                </button>
            </div>
        </div>
    </div>
    <div class="clearthis"></div>
    <div id="your-say-list">
    </div>
  
 {*  {$comment_pag_str}*}
   

</div>            