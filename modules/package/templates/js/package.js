var Package = function(form,button){
	this.form = form;
    this.btn = button;
    this.init();
}

Package.prototype = {
	callback_func :[],
    init:function(){
        var self = this;
        jQuery(this.btn).bind('click',function(){
            self.submit();
        })
    },
	submit: function() {
		var validation = new Validation(this.form);
        var ok2 = validation.isValid();

		var ok = true;
		if (this.callback_func.length > 0) {
			for (var i = 0; i < this.callback_func.length ;i++) {
				if (this.callback_func[i]()==false){
					ok = false;
				}
			}
		}

		if (ok == true && ok2 == true) {
			jQuery(this.form).submit();
		}
	},

	flushCallback: function(){
		this.callback_func = [];
	}
}