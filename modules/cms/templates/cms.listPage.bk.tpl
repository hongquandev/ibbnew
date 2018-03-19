{literal}
<script type="text/javascript" src="../../modules/property/templates/js/property.js"></script>
<script type="text/javascript">
    var pro = new Property();
</script>
<link href="/modules/cms/templates/css/style.css" type="text/css" rel="stylesheet"/>
{/literal}

<div class="container-l">
    <div class="container-r">
        <div class="container col2-right-layout">
            <div class="main">
            {if isset($error)}
                <div class="col-main cms" style="width:auto;margin: 20px 0px 30px 0px;">
                    <h3 style="margin-bottom:20px;">Page Not Found 11</h3>
                    <dl>
                        <dt>The page you requested was not found, and we have a fine guess why.</dt>
                        <dd>
                        </dd>
                    </dl>
                    <dl>
                        <dt>What can you do?</dt>
                        <dd>Have no fear, help is near! There are many ways you can get back on track with {$site_title_config}</dd>
                        <dd>
                            <ul class="disc" style="list-style-type:circle">
                                <li><b><a onclick="history.go(-1); return false;" href="#" style="color:#980000;">Go back</a></b> to the
                                    previous page.
                                </li>
                            </ul>
                        </dd>
                    </dl>
                </div>
            {else}
                <div class="col-main cms" style="width:auto;margin: 20px 0px 30px 0px;">
                    <h3> {$row.title} </h3>
                    {$row.content}
                </div>
                <!--
                <div class="col-right">
                {include file = "`$ROOTPATH`/modules/general/templates/quicksearch.tpl"}
                    <div class="advertisement-box" align="center">
                        <ul class="adv-list">
                            {foreach from=$rowbanner item=rowbanner}
                                <li>
                                    <a href="/?module=cms& action=counter-banner& id={$rowbanner.banner_id}"
                                       target="_blank">
                                        <img src="../../store/uploads/banner/images/{$rowbanner.file}"
                                             style="max-width:280px;" alt=""/>
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
                -->
            {/if}
            <div class="clearthis"></div>
			</div>
		</div>
	</div>
</div>
