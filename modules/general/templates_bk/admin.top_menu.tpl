{literal}
<script type="text/javascript" language="javascript">
jQuery(document).ready(function() {
    dashboard.init();
});
</script>
{/literal}
<div class="globalNav _bottomNav">
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
