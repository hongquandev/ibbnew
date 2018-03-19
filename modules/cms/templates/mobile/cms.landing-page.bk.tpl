{literal}
    <style type="text/css">
    </style>
{/literal}
{literal}
<script type="text/javascript" src="/modules/general/templates/js/jquery-ui.min.js"></script>
<link rel="stylesheet" href="/modules/cms/templates/css/jquery-ui.css" type="text/css" />

<link type="text/css" href="/modules/cms/templates/css/jquery.jscrollpane.css" rel="stylesheet"/>
<link type="text/css" href="/modules/cms/templates/mobile/css/ibb.jscrollpane.css" rel="stylesheet"/>


<script type="text/javascript" src="/modules/cms/templates/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="/modules/cms/templates/js/jquery.jscrollpane.min.js"></script>

<script type="text/javascript" src="/modules/general/templates/mobile/js/term.popup.js"></script>
{/literal}
<div class="container-l">
    <div class="container-r">
        <div class="container">
            <div class="main">
                <div class="landing-p" id="landing-p">
                    <div class="landing-p-content">
                        {if isset($row.content) and strlen($row.content) > 0 }
                            <div id="content-lapa" class="bor scroll-pane" style="height:400px; padding:15px;">{$row.content}</div>
                        {/if}
                        {if isset($faq_rows) and is_array($faq_rows) and count($faq_rows)>0}
                            <div class="lp-block-mid bor" id="qa_content">
                                <div class="common-questions questions" style="padding: 15px 25px 15px 25px;">
                                {foreach from = $faq_rows item = row}
                                    <div class="q-item">
                                        <div class="q-title">
                                            <p class="title" >
                                                <a href="javascript:void(0)"  onclick="showNode('{$row.content_id}')" id="q{$row.content_id}" name="q{$row.content_id}">
                                                    <img src="modules/general/templates/images/IBB_1.png" width="16px;" class="faq" id="img1{$row.content_id}"/>
                                                    <span class="ttr">{$row.question}</span>
                                                </a>
                                            </p>
                                            <div class="clearthis"></div>
                                        </div>
                                        <div class="q-content"  id="a{$row.content_id}" style="display:none;">
                                            <div>{$row.answer}</div>
                                        </div>
                                    </div>
                                {/foreach}
                                </div>
                            </div>
                        {/if}
                        <div class="lp-block-bottom">
                        </div>
                    </div>
                </div> <!-- End Colum Left -->
                <div class="clearthis">
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        function showNode(id) {
            var success = document.getElementById('a'+id);
            if (success.style.display == "none") {
            document.getElementById('a'+id).style.display = "block";
            document.getElementById('img1'+id).src = "modules/general/templates/images/IBB_2.png";
            } else 	{
            document.getElementById('img1'+id).src = "modules/general/templates/images/IBB_1.png";
            document.getElementById('a'+id).style.display = "none";
            }
        }
        /*jQuery('#content-lapa').shortscroll();*/
		/*
        jQuery('#content-lapa').shortscroll({
            scrollSpeed:110
        });
		*/
		$(function() {
			$('.scroll-pane').jScrollPane();
		});

    </script>
{/literal}
