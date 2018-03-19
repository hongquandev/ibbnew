<link rel="stylesheet" type="text/css" href="modules/general/templates/style/faq_style.css" />
<script src="modules/contentfaq/templates/js/drop_list.js" type="text/javascript"></script>
<div class="container-l">
	<div class="container-r">
		<div class="container col2-right-layout">
			<div class="main">
                <div class="col-main-full cms" style="width:auto;margin: 20px 0px 30px 0px;">
                    <h3 style="margin-bottom:45px;">FAQ</h3>
                    <div class="common-questions">
                        {if $action == 'faq'}
                            {include file = 'contentfaq.search.tpl'}
                            {include file = 'contentfaq.listfaq.tpl'}
                        {/if}
                    </div>
                </div>
                <div class="clearthis"></div>
			</div>
		</div>
	</div>
</div>