{literal}
<script type="text/javascript">
var search_overlay = new Search();
        search_overlay._frm = '#frmCustomize';
        search_overlay._text_search = '#suburb';
        search_overlay._overlay_container = '#search_overlay';
        search_overlay._url_suff = '&type=suburb1';

        search_overlay._success = function(data) {
            var info = jQuery.parseJSON(data);
            var content_str = "";
            var id = 0;
            if (info.length > 0) {
                search_overlay._total = info.length;
                for (i = 0; i < info.length; i++) {
                    var id = 'sitem_' + i;
                    content_str +="<li onclick='search_overlay.set2SearchText(this)' id='"+id+"'>"+info[i]+"</li>";
                    search_overlay._item.push(id);
             }
        }

    if (content_str.length > 0) {
        jQuery(search_overlay._overlay_container).html(content_str);
        jQuery(search_overlay._overlay_container).show();
        jQuery(search_overlay._overlay_container).width(jQuery(search_overlay._text_search).width());
    } else {
        jQuery(search_overlay._overlay_container).hide();
    }
}
    document.onclick = function() {search_overlay.closeOverlay()};
    Cufon.replace('#txtt');
    jQuery(document).ready(
        changeCountry($('#country').val())
    );

</script>
{/literal}

{*<div id="customize_loading" style="display:inline;">
            <img src="/modules/general/templates/images/loading.gif" style="height:30px;"/>
</div>*}
<div class="title"><h2 id="txtt"> Custom email to <span id="btnclosex" class="btnclosex-popup-newsletter" onclick="closeCustomize()">x</span></h2> </div>
<div class="content" style="padding:5px;">
    <form name="frmCustomize" id="frmCustomize" method="post" onsubmit="return customize.isSubmit('#frmCustomize');">

        <span class="sub_title">Choose email to:</span>
        <div class="input-pop-newsletter-customize">
            {*<input type="checkbox" name="vendors" value="vendors"> Vendors</input>
            <input class="child-input-pop-newsletter-customize" type="checkbox" name="buyers" value="buyers"> Buyers</input>
            <input class="child-input-pop-newsletter-customize" type="checkbox" name="partners" value="partners"> Partners</input>*}
            {assign var="i" value=0}
            {foreach from=$options_users key=k item=value}
                <input type="checkbox" name="users[]" value="{$k}"
                       {if $i > 0}style="margin-left:4px;"{/if}
                       {if $form_data.user != null && in_array($k,$form_data.user)}checked="checked"{/if}> {$value}s
                {assign var="i" value=$i+1}
            {/foreach}
        </div>
        <span class="sub_title">Accept Region:</span>
        <div class="main-pop-newsletter-customize">
            <div class="pop-newsletter-customize">
                <span>Suburb</span>
                <input type="text" id="suburb" class="input-text disable-auto-complete" value="{$form_data.suburb}" onclick="search_overlay.getData(this)" onkeyup="search_overlay.moveByKey(event)"/>
           </div>
            <div class="clearthis"></div>
            <ul style="list-style:none;">
                <div id="search_overlay" class="search_overlay search-overlay-newsletter-customize" style="display:none;"></div>
            </ul>
            <div class="pop-newsletter-customize">
                <span>Country</span>
                <select name="fields[country]" id="country" onchange="changeCountry($('#country').val())">
                        {html_options options = $option_country selected = $form_data.country}
                </select>
            </div>
            <div class="clearthis"></div>
            <div class="pop-newsletter-customize">
                <span>State</span>
                <select name="fields[state]" id="state">
                        {html_options options = $option_state selected = $form_data.state}
                </select>
                <input type="text" id="other_state" name="fi" class="input-text" value="{$form_data.other_state}"/>
            </div>

        </div>
    </form>
     <div class="clearthis"></div>
      <div class="button-pop-newsletter-customize">
        <button class="btn-red" name="submit" id="submit" onclick="submitCustomize()"><span><span>Submit</span></span</button>
        <button class="btn-red" name="cancel" id="cancel" onclick="closeCustomize()"><span><span>Cancel</span></span></button>
      </div>
</div>



