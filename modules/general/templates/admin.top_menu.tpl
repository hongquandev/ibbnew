{literal}
<script type="text/javascript" language="javascript">
jQuery(document).ready(function() {
    dashboard.init();
});
</script>
{/literal}
<div id="admin-globalNav" class="globalNav _bottomNav">
    <div style="width: 43px;" class="globalNavMenu _bottomNavMenu">
        <ul class="sidebarNavMenu">
            <li>
                <a class="_organizations firstlevel" href="javascript:void(0)" onclick="">
                    <span class="trim rb-a-3">
                        <span class="icon-19 personal"></span>
                        <span class="text">
                            Welcome <b>{$rows.username}</b>
                        </span>
                        <span class="icon-13 selected"></span>
                    </span>
                </a>
            </li>
            {$top_menu}
        </ul>
        <hr class="sidebarNavMenuDivider">
        <ul class="sidebarNavMenu">
            <li>
				<a class="log-out firstlevel" onclick="window.location='index.php?action=logout'; return false;">
					<span class="trim rb-a-3">
						<span class="icon-19 log-out"></span>
						<span class="text">Log Out</span>
					</span>
				</a>
			</li>
        </ul>
        <hr class="sidebarNavMenuDivider">
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/modules/general/templates/slicknav/jquery.slicknav.js"></script>
<link rel="stylesheet" type="text/css" href="/modules/general/templates/slicknav/slicknav.css" />
<div id="slickNav" class="slickNav-top" style="display: none">
    <ul id="slick-menu">
        {$top_menu_slick}
        <li>
            <a class="log-out firstlevel" onclick="window.location='index.php?action=logout'; return false;">
                <span class="trim rb-a-3">
                    <span class="icon-19 log-out"></span>
                    <span class="text">Log Out</span>
                </span>
            </a>
        </li>
    </ul>
</div>
{literal}
    <script type="text/javascript">
        jQuery('#slick-menu').slicknav();
        function resizeMenu() {
            if(window.innerWidth < 970){
                jQuery("#admin-globalNav").hide();
                jQuery(".slicknav_menu").show();
            }else{
                jQuery("#admin-globalNav").show();
                jQuery(".slicknav_menu").hide();
            }
        }
        jQuery( window ).resize(function() {
            resizeMenu();
        });
        resizeMenu();
</script>
{/literal}