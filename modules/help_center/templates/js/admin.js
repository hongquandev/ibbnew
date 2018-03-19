/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 9:10 AM
 * To change this template use File | Settings | File Templates.
 */
var Help = function(frm, tabs){
    this.form = frm,
    this.tabContainers = tabs
}
Help.prototype = {
    submit: function(){
        var validation = new Validation(this.form);
		if (validation.isValid()) {
            $(this.tabContainers).hide();
            $(this.form+' #submit').val(1);
			jQuery(this.form).submit();
		}
    },
    list:function(url){
        $.post(url,{},function(data){
                    $('#container').html(data);
               },'html')
    },
    toggle:function(obj){
        $(obj).parent().children('div.answer').toggle();
    }
};