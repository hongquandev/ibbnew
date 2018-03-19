<script type="text/javascript" src="../modules/package/templates/js/jsonOption.js"></script>
<input type="hidden" name="options" id="options" value='{$form_data.options}'/>
<script type="text/javascript">
    var url = '../modules/package/action.admin.php?action=load-option-list&group_id={$package_id}&token={$token}';
    {literal}
    function loadOptionList(url){
        $.post(url,{option:jQuery('#options').val()}, function(data) {
                    var result = jQuery.parseJSON(data);
                    if (result.html) {
                        $('#option-list').html(result.html);
                    }
                }, 'html');
    }
    function gotoPage(p){
        var _url = url+'&p='+p;
        loadOptionList(_url);
    }
    $(document).ready(function(){
        loadOptionList(url);
    });
    {/literal}
</script>
<div class="edit-table" id="option-list"></div>