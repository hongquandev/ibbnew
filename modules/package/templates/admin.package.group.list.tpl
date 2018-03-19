<script type="text/javascript">
    var token = '{$token}';
    {literal}
    function loadList(url){
        $.post(url,{},function(data){
                $('#group_list').html(data);
               },'html');
    }
    $(document).ready(function(){
        var url = '../modules/package/action.admin.php?action=load-group-list&token='+token;
        loadList(url);
    });
    {/literal}
</script>
<div class="edit-table" style="max-height:400px" id="group_list">
</div>
