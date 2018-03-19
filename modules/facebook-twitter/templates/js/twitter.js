var Twitter = function(){

}
Twitter.prototype = {
    addAccount: function(user){
        var url = '/modules/agent/action.php?action=add_another_tw';
        $.post(url,{info:user},function(data){

                },'html');
    }
}


