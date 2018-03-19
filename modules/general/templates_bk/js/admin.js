// JavaScript Document
var http = false;

if(navigator.appName == "Microsoft Internet Explorer") {
	http = new ActiveXObject("Microsoft.XMLHTTP");
} else {
	http = new XMLHttpRequest();
    
}


function showMsg(msg) {
	document.getElementById('msgID').style.display = '';
	document.getElementById('msgID').innerHTML = msg;
}

function hideMsg() {
	document.getElementById('msgID').style.display = 'none';
}

function deleteItem(url) {
	http.abort();
	//http.open("GET", url, true);
	http.open("POST", url, true);
	http.onreadystatechange=function() {
		if(http.readyState == 4) {
			showMsg(http.responseText);
		}
	}
	http.send(null);
}

function activeItemF5(url){
	http.abort();
	//http.open("GET", url, true);
	http.open("POST", url, true);
	http.onreadystatechange = function() {
		if(http.readyState == 4) {
			if (http.responseText == 'logout') {
				showMess('Please login.');
			} else {
                var data=jQuery.parseJSON(http.responseText);
                var id=data.property_id;
				showMsg(data.msg);
				//document.getElementById('ext-gen54').click();
                if(data.action=='active'){
                    if (data.status==1)
                    {
                        jQuery('#status-'+id).html('Enabled');
                        jQuery('#status-'+id).css('color','#009900')
                    } else {
                        jQuery('#status-'+id).html('Disabled');
                        jQuery('#status-'+id).css('color','#FF0000');
                    }
                }
                if(data.action=='actives'){
                    if (data.focus==1)
                    {
                        jQuery('#focus-'+id).html('Yes');
                        jQuery('#focus-'+id).css('color','#009900')
                    } else {
                        jQuery('#focus-'+id).html('No');
                        jQuery('#focus-'+id).css('color','#FF0000');
                    }
                }
                if(data.action=='allow'){
                    if (data.feature==1)
                    {
                        jQuery('#feature-'+id).html('Yes');
                        jQuery('#feature-'+id).css('color','#009900')
                    } else {
                        jQuery('#feature-'+id).html('No');
                        jQuery('#feature-'+id).css('color','#FF0000');
                    }
                }

			}

		}
	}
	http.send(null);
}

function deleteItemF5(url) {
	Ext.Msg.show({
		title:'Delete record?'
		,msg:'Do you really want to delete ?'
		,icon:Ext.Msg.QUESTION
		,buttons:Ext.Msg.YESNO
		,scope:this
		,fn:function(response) {
			if('yes' !== response) {
				return ;
			}
			
			http.abort();
			//http.open("GET", url, true);
			http.open("POST", url, true);
			http.onreadystatechange=function() {
				if(http.readyState == 4) {
					if (http.responseText == 'logout') {
						alert('Please login.');
					} else {
						showMsg(http.responseText);
						document.getElementById('ext-gen54').click();
					}
				}
			}
			http.send(null);
		}
	});
}

function deleteItem2(url) {
	Ext.Msg.show({
		title:'Delete record?'
		,msg:'Do you really want to delete ?'
		,icon:Ext.Msg.QUESTION
		,buttons:Ext.Msg.YESNO
		,scope:this
		,fn:function(response) {
			if('yes' !== response) {
				return ;
			}
			document.location = url;
		}
	});
}

var form='frm' //Give the form name here

function SetChecked(val,chkName) {
	dml = document.forms[form];
	len = dml.elements.length;
	var i = 0;
	for(i = 0 ; i < len ; i++) {
		if (dml.elements[i].name==chkName) {
			dml.elements[i].checked=val;
		}
	}
}
//BEGIN ADVANCE SEARCH
var DEFINE = {
	SEARCH_SELF : null,
    PROPERTY_SELF: null,
    NOTE_SELF: null,
    BANNER_SELF: null
}
var Search = function(){
    DEFINE.SEARCH_SELF = this;
	this._item = [];
	this._current = -1;
	this._total = 0;
	this._frm = '';
	this._text_search = '';
    this._text_obj_1 = '';
    this._text_obj_2 = '';

	this._success = null;
	this._overlay_container = '';

	this._url_suff = '';
    this._name_id = 'sitem_';
    this._location = '';
}

Search.prototype = {


	getData: function(obj) {
		var val = jQuery(obj).val();
		var url = '/modules/property/action.php?action=search';
		if (this._url_suff.length > 0) {
			url = url + this._url_suff;
		}
		if (val.length > 0) {
			if (this._success != null) {
				jQuery.post(url,{region:val},this._success,'html');
			} else {
				jQuery.post(url,{region:val},this.onGetData,'html');
			}
		}
	},

	onGetData: function(data) {

	},

	set2SearchText: function(obj) {
		jQuery(this._text_search).val(jQuery(obj).text());
	},
    //suburb
    setValue: function(obj) {
        var value = jQuery(obj).text();
        var word = value.split(" ");
        var l = word.length;
        jQuery(this._text_obj_2).val(word[l-1]);
        var state = word[l-2];
        var suburb = value.substring(0,value.indexOf(state));
        jQuery(this._text_search).val(suburb);
        var url = '/modules/property/action.php?action=search&type=region';
	    jQuery.post(url,{region:state},this._getValue);
        this.closeOverlay();
	},
    //end suburb

    set2SearchText_agent:function(obj,agent_id,status){
        //var agent_id = jQuery(obj).val();
        var token = jQuery('#token').val();
        if (status == 1){
            if (this._id != 0) {
                document.location = this._location.replace('[1]',agent_id)+token;
            }else{
                 jQuery(this._text_obj_1).val(agent_id);
                 
            }


        }else{
            Ext.Msg.show({
                title:'Warning !'
                ,msg:'Agent does\'s active.'
                ,icon:Ext.Msg.WARNING
                ,buttons:Ext.Msg.OK
                ,fn:function(response) {
                    $.post('/modules/property/action.admin.php?action=get-nameAgent&token='+token,{agent_id:$(DEFINE.SEARCH_SELF._text_obj_1).val()},function(data){
                                var result = jQuery.parseJSON(data);
                                jQuery(DEFINE.SEARCH_SELF._text_search).val(result.data);
                            });
		        }

	        });


        }

    },
	moveByKey: function(e){
		if (window.event) {
			e = window.event;
		}
		//alert('movebyKey');
		switch (e.keyCode) {
			case 40://down
				if (this._current < this._total) {
					this._current++;

				}
                if (this._current > this._total){
                    this._current = 0;
                }

			break;
			case 38://up
				if (this._current > 0) {
					this._current--;
				}
                if (this._current > this._total){
                    this._current = 0;
                }

			break;
			case 13://enter
//				if (this._current < 0) {
//					jQuery('#is_submit',this._frm).val(1);
//					jQuery(this._frm).submit();
//					this.closeOverlay();
//					return true;
//				} else {
					var _tmp = jQuery('[id='+this._name_id+this._current+']').html();
					if (this._text_obj_1 != '')
                    {
                        if (this._text_obj_2 != ''){
                            this.setValue('#'+this._name_id+this._current);
                        }else{
                            var status = $('#'+this._name_id+this._current).hasClass('li-inactive')?0:1;
                            var agent_id = parseInt($('#'+this._name_id+this._current).attr('class'));
                            this.set2SearchText_agent('#'+this._name_id+this._current,agent_id,status)
                        }

                    }
                    else {jQuery(this._text_search).val(_tmp);}
					this._current = -1;
					this.closeOverlay();
//				}

//				jQuery('#is_submit',this._frm).val(0);

//				return false;
			break;
			default:
				var obj = e.target ? e.target: e.srcElement;
				this.getData(obj);
			break;
		}

		if (this._total > 0) {
			jQuery('[id^='+this._name_id+']').removeClass('search_move');
			jQuery('[id='+this._name_id+this._current+']').addClass('search_move');
            //div scroll
            //jQuery(this._overlay_container).scrolling;
		}
	},

	closeOverlay: function() {
		jQuery(this._overlay_container).hide();
	}


}
//END




function showWaitBox() {
	Ext.MessageBox.show({
	   title : 'Please wait',
	   msg : 'Loading items...',
	   progressText : 'Initializing...',
	   width : 300,
	   progress : true,
	   closable : false,
	   animEl : 'mb6'
	});
	
	// this hideous block creates the bogus progress
	var f = function(v){
		return function(){
			if(v == 12){
				Ext.MessageBox.hide();
			}else{
				var i = v/11;
				Ext.MessageBox.updateProgress(i, Math.round(100*i)+'% completed');
			}
	   };
	};
	for(var i = 1; i < 13; i++){
	   setTimeout(f(i), i*500);
	}
}

function hideWaitBox(){
	Ext.MessageBox.hide();
}

function outAction(type,val){
	switch (type) {
        case 'exportCSV':
                //alert(val);
                document.location = ROOTURL +'?module=property&action=exportCSV&page=AdminRegisterToBid&file_name=RegisterToBid&store_ids='+val;
            break;
		case 'delete':
			Ext.Msg.show({
				title :'Delete record?'
				,msg :'Do you really want to delete ?'
				,icon : Ext.Msg.QUESTION
				,buttons : Ext.Msg.YESNO
				,scope : this
				,fn : function(response) {
					if('yes' !== response) {
						return ;
					}
					ajaxAction(type,val,session.action_link.replace('[1]','action=delete-' + session.action_type));
				}
			});
		break;
		case 'multidelete':
			Ext.Msg.show({
				title : 'Delete record?'
				,msg : 'Do you really want to delete ?'
				,icon : Ext.Msg.QUESTION
				,buttons : Ext.Msg.YESNO
				,scope : this
				,fn : function(response) {
					if('yes' !== response) {
						return ;
					}
					ajaxAction(type,val,session.action_link.replace('[1]','action=multidelete-' + session.action_type));
				}
			});
		break;
        case 'multiaddcenter':
            ajaxAction(type,val,session.action_link.replace('[1]','action=' + type + '-' + session.action_type));
            break;
		default:
			ajaxAction(type,val,session.action_link.replace('[1]','action=' + type + '-' + session.action_type));
		break;
	}
}
