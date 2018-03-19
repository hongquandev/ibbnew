//FOR enctype="multipart/form-data" & "application/octet-stream"

function createDocUploader(btn,lst,url,is_admin){
	var uploader = new qq.FileUploader({
		element: document.getElementById(btn),
		listElement: document.getElementById(lst),
		action: url,
		multiple:false,
		debug: true,
		onComplete:function(id, fileName, result){
			if(result.deleteAction){
				var li = document.getElementById(lst).firstChild;
				var ar = qq.getByClass(li,'qq-upload-del');
				if (is_admin != 1) is_admin = 0
				qq.attach(ar[0],'click',function(){deleteAction(result.deleteAction.url.replace(/&amp;/g,'&'),result.deleteAction.target,is_admin);});
			}
		}
	});           
}


//BEGIN DOC
var Doc = function(){
	this.btn = '';
	this.lst = '';
	this.url = '';
}

Doc.prototype = {
	uploader:function(btn,lst,url){
		this.btn = btn;
		this.lst = lst;
		this.url = url;
		
		var self = this;
		var uploader = new qq.FileUploader({
			element: document.getElementById(btn),
			listElement: document.getElementById(lst),
			action: url,
			multiple:false,
			debug: true,
			onComplete:function(id, fileName, result){
				//console.log(result);
				if (result.error) {
					//alert('error');
				} else if (result.nextAction){
					self[result.nextAction.method](result.nextAction.args);
				}
				
				if (result.success) {
					//alert('success');
				}
			},
			fileTemplate: '<li>' +
								'<span class="qq-upload-file" style="display:none"></span>' +
								'<span class="qq-upload-spinner"></span>' +
								'<span class="qq-upload-size"></span>' +
								//'<a class="qq-upload-uploaded" href="javascript:void()">Uploading</a>' +
								'<a class="qq-upload-cancel" href="javascript:void()">Cancel</a>' +
								'<a class="qq-upload-failed-text">Failed</a>' +
						  '</li>', 
			/*template: *//*'<li>' +
								'<span class="qq-upload-file" style="display:none"></span>' +
								'<span class="qq-upload-spinner"></span>' +
								'<span class="qq-upload-size"></span>' +
								//'<a class="qq-upload-uploaded" href="javascript:void()">Uploading</a>' +
								'<a class="qq-upload-cancel" href="javascript:void()">Cancel</a>' +
								'<a class="qq-upload-failed-text">Failed</a>' +
						  '</li>',*//*
                        '<div class="qq-uploader">' +
                        '<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>' +
                        '<div class="qq-upload-button">Upload a video</div>' +
                        '<ul  class="qq-upload-list"></ul>' +
                        '</div>',*/
			classes: {
				// used to get elements from templates
				button: 'qq-upload-button',
				list: 'qq-upload-list',
				file: 'qq-upload-file',
				spinner: 'qq-upload-spinner',
				size: 'qq-upload-size',
				del: 'qq-upload-del',
				cancel: 'qq-upload-cancel',
				// added to list item when upload completes
				// used in css to hide progress spinner
				success: 'qq-upload-success',
				fail: 'qq-upload-fail'
			}
			
		});    		
	},
	'showDoc':function(args){
		var url_delete = args.actionDelete.replace(/&amp;/g,'&');
		var url_down = args.actionDown.replace(/&amp;/g,'&');
		var container = $('#'+args.target);
		var is_admin = args.admin == 1 ? 1 : 0;
		
		container.html("<li class='qq-upload-success'><span class='qq-upload-file'>"+args.file_name+"</span><a class='qq-upload-del' href='javascript:void(0)' onclick=\"pro.downDoc('"+url_down+"')\">Download</a><span class='split'>|</span><a class='qq-upload-del' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','lst_"+args.document_id+"','"+is_admin+"')\">Delete</a></li>");
	}
};

//END

//BEGIN MEDIA
var Media = function(){
	this.btn = '';
	this.lst = '';
	this.url = '';
	this.multiple = false;
	this.max_allow = 0;
	this.ie = 0;
}

Media.prototype = {
	init : function () {
		qq.extend(qq.FileUploader.prototype, 
			{_createUploadButton: function(element){
				var self = this;
				return new qq.UploadButton({
					element: element,
					multiple: this._options.multiple && qq.UploadHandlerXhr.isSupported(),
					onChange: function(input){
						//if (self.max_allow == 'all' || parseInt(self.max_allow) >= input.files.length || typeof(self.max_allow) == 'undefined') {
							if (self.max_allow == 'all' || self.ie == 1 || (self.ie == 0 &&  parseInt(self.max_allow) >= input.files.length) || typeof(self.max_allow) == 'undefined') {
							self._onInputChange(input)
						} else {
                            if (typeof(Ext) != 'undefined' ){
                                Ext.Msg.show({title : 'Warning !',
                                              msg : 'You just only upload ' + self.max_allow + ' max files.',
                                              icon : Ext.Msg.WARNING,
                                              buttons : Ext.Msg.OK});
                            }else{
                                showMess('You just only upload ' + self.max_allow + ' max files.')
                            }

						}
					}        
				});           
			} 
		});
	},
	
	uploader:function(btn,lst,url,is_admin){
		this.btn = btn;
		this.lst = lst;
		this.url = url;
		
		var self = this;
		var uploader = new qq.FileUploader({
			element: document.getElementById(btn),
			listElement: document.getElementById(lst),
			action: url,
			multiple: self.multiple,
			debug: true,
			maxConnections: 1,
            fileTemplate: '<li>' +
								'<span class="qq-upload-file" style="display:none"></span>' +
								'<span class="qq-upload-spinner"></span>' +
								'<span class="qq-upload-size"></span>' +
								//'<a class="qq-upload-uploaded" href="javascript:void()">Uploading</a>' +
								'<a class="qq-upload-cancel" href="javascript:void()">Cancel</a>' +
								'<a class="qq-upload-failed-text">Failed</a>' +
						  '</li>'
			,classes: {
				button: 'qq-upload-button',
				list: 'qq-upload-list',
				file: 'qq-upload-file',
				spinner: 'qq-upload-spinner',
				size: 'qq-upload-size',
				del: 'qq-upload-del',
				cancel: 'qq-upload-cancel',
				success: 'qq-upload-success',
				fail: 'qq-upload-fail'
			}
			
			,onProgress: function(id, fileName, loaded, total){
			}
			
			,onComplete: function(id, fileName, result){
				if(result.nextAction){
					self[result.nextAction.method](result.nextAction.args);
				}
				
				if (result.error) {
                    if (is_admin == 1){
                        Ext.Msg.show({title : 'Warning !', msg : result.error, icon : Ext.Msg.WARNING, buttons : Ext.Msg.OK});
                    } else {
                        showMess(result.error, '', false);
                    }
				}

				if (result.success) {
					//alert('success');
				}
            }
			
			,onCancel: function(id, fileName){
            }
			
			,showMessage: function(message){
				//alert(message);
			} 
			
			,_createUploadButton: function(element){
				var self = this;
				
				return new qq.UploadButton({
					element: element,
					multiple: this._options.multiple && qq.UploadHandlerXhr.isSupported(),
					onChange: function(input){
						self._onInputChange(input);
					}        
				});           
			}   
		});    		
	}
	
	,'showPhoto':function(args){
		var url_delete = args.actionDelete.replace(/&amp;/g,'&');
		var url_default = args.actionDefault.replace(/&amp;/g,'&');
		var container = $('#'+args.target);
		//var is_admin = args.admin == 1 ? 1 : 0;
        var is_admin = args.is_admin == 1 ? 1 : 0;
		container.append("<li id='photo_"+args.media_id+"'><img src='"+args.image+"'/><br/><select class='input-select' id='default_"+args.media_id+"' onchange=\"defaultAction('"+url_default+"&property_id="+args.property_id+"&default='+this.value,'default_"+args.media_id+"','"+is_admin+"')\"> <option value='0'>none</option><option value='1'>default</option></select><a style='float: left;margin-left: 82px;' class='qq-upload-del2' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','photo_"+args.media_id+"','"+is_admin+"')\">Delete</a></li>");
		if (is_admin == 0){
            $("#default_"+args.media_id).uniform();
        }
	}
	/*
	,'showVideo':function(args){
		if (args.error) {
			
		} else {
			var is_admin = args.admin == 1 ? 1 : 0;
            var link = args.image;
			var container = $('#'+args.target);
			
			var url_delete = args.actionDelete.replace(/&amp;/g,'&');
			var url_default = args.actionDefault.replace(/&amp;/g,'&');

			
			//var object_str = "<div id='video_"+args.media_id+"'><object id='player"+args.media_id+"' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' name='player"+args.media_id+"' width='328' height='200'><param name='movie' value='/utils/flash-player/jwplayer/player.swf'/><param name='allowfullscreen' value='true'/><param name='allowscriptaccess' value='always'/>" +
            //        "<param name='flashvars'='file="+link+"'/><embed type='application/x-shockwave-flash' id='player_"+args.media_id+"' name='player_"+args.media_id+"' src='/utils/flash-player/jwplayer/player.swf'  width='328' height='200' allowscriptaccess='always' allowfullscreen='true' flashvars='file=/"+args.image+"' /> </object><br/><a class='qq-upload-del2' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','video_"+args.media_id+"','"+is_admin+"')\">Delete</a></div>";
            
			//
			if (args.ext == 'wmv') {
				var object_str = "<object id='player_"+args.media_id+"' width='328' height='200' classid='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' standby='Loading Windows Media Player components...' type='application/x-oleobject' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112'><param name='filename' value='"+args.image+"'><param name='Showcontrols' value='True'><param name='autoStart' value='True'><embed type='application/x-mplayer2' src='"+args.image+"' name='MediaPlayer' width='328' height='200'></embed></object>";
				
			} else {
				var object_str = "<embed type='application/x-shockwave-flash' id='player_"+args.media_id+"' name='player_"+args.media_id+"' src='/utils/flash-player/jwplayer/player.swf'  width='328' height='200' allowscriptaccess='always' allowfullscreen='true' flashvars='file="+args.image+"' wmode='transparent'/>";				
			}
			
			var container_str = "<div id='video_"+args.media_id+"'>" + object_str + "<br/><a class='qq-upload-del2' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','video_"+args.media_id+"','"+is_admin+"')\">Delete</a></div>";
			 

			
			var sub_container = qq.toElement(container_str);
			container.append(sub_container);
		}
	},
	*/
,'showVideo':function(args){
		if (args.error) {
			
		} else {
			var is_admin = args.admin == 1 ? 1 : 0;
            var link = args.image;
			var container = $('#'+args.target);
			
			var url_delete = args.actionDelete.replace(/&amp;/g,'&');
			var url_default = args.actionDefault.replace(/&amp;/g,'&');

			
			//var object_str = "<div id='video_"+args.media_id+"'><object id='player"+args.media_id+"' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' name='player"+args.media_id+"' width='328' height='200'><param name='movie' value='/utils/flash-player/jwplayer/player.swf'/><param name='allowfullscreen' value='true'/><param name='allowscriptaccess' value='always'/>" +
            //        "<param name='flashvars'='file="+link+"'/><embed type='application/x-shockwave-flash' id='player_"+args.media_id+"' name='player_"+args.media_id+"' src='/utils/flash-player/jwplayer/player.swf'  width='328' height='200' allowscriptaccess='always' allowfullscreen='true' flashvars='file=/"+args.image+"' /> </object><br/><a class='qq-upload-del2' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','video_"+args.media_id+"','"+is_admin+"')\">Delete</a></div>";
            
			//
			if (args.ext == 'wmv') {
				var object_str = "<object id='player_"+args.media_id+"' width='328' height='200' classid='CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95' standby='Loading Windows Media Player components...' type='application/x-oleobject' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112'><param name='filename' value='"+args.image+"'><param name='Showcontrols' value='True'><param name='autoStart' value='True'><embed type='application/x-mplayer2' src='"+args.image+"' name='MediaPlayer' width='328' height='200'></embed></object>";
				
			} else {
				/*
				var object_str = "<embed type='application/x-shockwave-flash' id='player_"+args.media_id+"' name='player_"+args.media_id+"' src='/utils/flash-player/jwplayer/player.swf'  width='328' height='200' allowscriptaccess='always' allowfullscreen='true' flashvars='file="+args.image+"' wmode='transparent'/>";				
			*/
				var object_str = '<img src="'+args.url+'"/>';
			}
			
			var container_str = "<div id='video_"+args.media_id+"'>" + object_str + "<br/><a class='qq-upload-del2' href='javascript:void(0)' onclick=\"deleteAction('"+url_delete+"','video_"+args.media_id+"','"+is_admin+"')\">Delete</a></div>";
			 
			
			var sub_container = qq.toElement(container_str);
			container.append(sub_container);
		}
	},	
    viewLogo:function(args){
        $('#'+args.target).html('<img src="' + args.image + '"/>');
    },
	viewBackground: function(args){
        $('#'+args.target).html('<a class="photoThumbDiv">\
                                    <i style="background-image: url('+args.image+');\
                                        class="photoThumbImg"></i>\
                                    <span class="icons close-btn" lang="'+args.type+'"></span>\
                                 </a>');
        $('#'+args.target +' .photoThumbDiv .icons').bind('click', function() {
            if ($(this).attr("onClick") != undefined) {
            } else {
                if (args.admin && args.admin == 1){
                    self['agent'].deleteImage(this, $(this).attr('lang'), args.agent_id);
                }else{
                    self['agent'].deleteImage(this, $(this).attr('lang'));
                }
            }
        });
        $('#'+args.target +' .photoThumbDiv').hover(
                function () {
                    $(this).children('.icons').show();
                },
                function () {
                    $(this).children('.icons').hide();
                }
        );
    }
    ,'showLogo':function(args) {
        if ($('#'+args.container).length > 0) {
        } else {
            var html = '<li class="wide">\
                            <label><strong>Logo File</strong></label>\
                                <div class="input-box">\
                                    <div id="'+args.container+'"><div class="clearthis"></div></div>\
                                </div>\
                        </li>';
            if (args.admin){
                $('#'+this.btn).parent().append(html);
            }else{
                $(html).insertBefore('#upload-logo');
            }
        }
        $('#'+args.container).html('<img src="' + args.image + '"/>');
        if ($('#security_question').length > 0 && args.height > 200){
            $('#security_question').parent().attr('colspan',2);
        }
    }
	
	,'showBanner':function(args) {
		$('#banner_container').show();
        $('#banner_container img').attr('src', args.image);
		$('#banner_container #banner_file').val(args.file_name);
    }	
};


