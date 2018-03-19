<link rel="stylesheet" type="text/css" href="/modules/general/templates/lightbox/lightbox.css"/>
<script type="text/javascript" src="/modules/general/templates/lightbox/lightbox_plus_min.js"></script>    

<script type="text/javascript">
    var help = new Help('#frmSearch',tabContainers);
    var token = '{$token}';
    var tabs = [];
    var tabContainers = [];
    {literal}
        function pull(obj){
            $(obj).parent().children('div.answer').toggle();
            $(obj).parent().children('div.intro').toggle();
           // $(obj).parent().children('div.category').toggle();
            if ($(obj).hasClass('ques-close')){
                $(obj).removeClass('ques-close');
                $(obj).addClass('ques-open');
            }else{
                $(obj).addClass('ques-close');
                $(obj).removeClass('ques-open');
            }
        }
        /*function hover(obj){
            $('img.hover-arrow').hide();
            //$('ul.list-cat li').removeClass('active');
            $(obj).children('img.hover-arrow').show();
        }*/
        $(function () {
            $('ul.tabs a').each(function () {
                if (this.pathname == window.location.pathname || '/'+this.pathname==window.location.pathname) {
                tabs.push(this);
                tabContainers.push($(this.hash).get(0));
                }
            });
            $(tabs).click(function () {
                // hide all tabs
                $(tabContainers).hide().filter(this.hash).slideDown();
                $('img.hover-arrow').hide();
                $('.list-cat li').each(function() {
                    $(this).removeClass('active');
                });
                // set up the selected class
                $(tabs).removeClass('selected');
                $(this).addClass('selected');
                $('.tabs .selected').parent().addClass('active');
                $('.tabs .selected').parent().children('img.hover-arrow').show();
                $('#search-data').hide();
                return false;
            });
        });
    {/literal}
</script>
<div class="help-container">
    <div style="height:71px;border-bottom:2px solid #E0E0E0;padding: 15px;">
        <img src="../modules/general/templates/images/logo.jpg" alt="Logo" class="logo">
    </div>
    <div class="col-2set" style="padding-right:0px !important;">
        <div class="col-1" style="height:10px;"></div>
        <div class="col-2" style="padding-left:13px">
            <div class="help-head">
                    <h2>Welcome to iBB Help Center</h2>
                    <div class="help-search" style="width:509px;">
                       <form id="frmSearch" name="frmSearch" action="{$form_action}" method="post">
                           <input type="hidden" value="0" id="submit" name="submit"/>
                           <input type="text" class="input-text" name="search" id="search" value="{$search_key}" style="display:inline;"/>
                           <button onclick="help.submit()" style="display:inline;"><img src="../modules/general/templates/images/btn-search.png"></button>
                       </form>
                    </div>
            </div>
        </div>
    </div>
    <div style="clear:both"></div>
    <div class="col-2set">
        <div class="col-1">
            <ul class="list-cat tabs">
                {foreach from = $cat_data item = cat}
                    <li id="{$cat.catID}">
                        <a href="#question-tag-{$cat.catID}">{$cat.title}</a>
                        <img class="hover-arrow" src="../modules/general/templates/images/arrow-bar.gif"/>
                    </li>
                {/foreach}
            </ul>
        </div>
        <div id="container" class="col-2 tabContent">
                {foreach from = $cat_data item = cat}
                    <div id="question-tag-{$cat.catID}" {$hideCategory}>
                        {foreach from = $cat.items item=row}
                            <div class="ques-container">
                                <a class="ques-close" href="javascript:void(0)" onclick="pull(this)">
                                   <span>{$row.question}</span>
                                </a>
                                <div class="answer">{*$row.answer*}
		                    {php}
		                    echo preg_replace_callback('/<img(.*?)>/', 'imgToLightBoxFormat', $this->_tpl_vars['row']['answer']);
		                    {/php}

				</div>
                            </div>
                        {/foreach}
                    </div>
                {/foreach}
                <div id="search-data">
                {if $found == 1}
                            {foreach from = $search_data item = row}
                                <div class="ques-container">
                                    <a class="ques-close" href="javascript:void(0)" onclick="pull(this)">
                                       <span>{$row.question}</span>

                                    </a>
                                    <div class="answer">
					{*$row.answer*}
		                    {php}
		                    echo preg_replace_callback('/<img(.*?)>/', 'imgToLightBoxFormat', $this->_tpl_vars['row']['answer']);
		                    {/php}
				    </div>
                                    <div class="intro">{$row.intro}</div>
                                    <div {$showCategory} class="category"><span>Category: </span>{$row.title}</div>
                            </div>
                            {/foreach}
                            <div class="clearthis"></div>
                            {$pag_str}
                {elseif $found && $found == 0}
                         <p style="font-weight:bold;">Your search returned no results. </p>
                         <ol class="number-list">
                             <li>Check the spelling of your words.</li>
                             <li>Try rewording your question or using different words.</li>
                         </ol>
                {/if}
                </div>
        </div>
    </div>
</div>