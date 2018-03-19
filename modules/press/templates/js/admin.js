/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 9:10 AM
 * To change this template use File | Settings | File Templates.
 */
var Press = function(frm){
    this.form = frm
}
Press.prototype = {
    callback_func :[],
    submit: function(track){
        var validation = new Validation(this.form);
		var ok = true;
        if (this.callback_func.length > 0) {
			for (i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}
        if (validation.isValid() && ok) {
            //$(this.tabContainers).hide();

            if (track){
                $(this.form+' #track').val(1);
            }
			jQuery(this.form).submit();
		}
    },
    flushCallback: function(){
		this.callback_func = [];
	},
    list:function(url){
        $.post(url,{},function(data){
                    $('#container').html(data);
               },'html')
    }
};