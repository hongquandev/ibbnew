</div>
<div class="footer f-l"  >
    <div class="footer f-r" >
        <div class="f-c"  >
            <div class="clearthis"></div>
            <div class="footer-site" style="padding-top: 10px; text-align: center; font-size: 12.1px;">
                <a style="color: #ffffff;" href="{$footer.link}" target="_blank" >{$footer.copyright}</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/modules/general/templates/mobile/js/footer.js" ></script>
{if isset($is_active) && $is_active == 0}
<script type="text/javascript" src="/modules/property/templates/js/property.js"></script>
<script type="text/javascript">
    {literal}
    $(document).ready(function () {
        showMess('Your account is not activated yet. Please check your email and click on the activation link to activate your account. Thank you !');
    });
    {/literal}
</script>
{/if}
</body>
</html>
