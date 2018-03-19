var Media = function(){
	this.btn = '';
	this.lst = '';
	this.url = '';
}

Media.prototype = {
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
				if(result.nextAction){
					self[result.nextAction.method](result.nextAction.args);
				}
				
				//console.log(result);
				if (result.error) {
					//alert('error');
				}
				
				if (result.success) {
					//alert('success');
				}
			},
			fileTemplate: '<li>' +
								'<span class="qq-upload-file" style="display:none"></span>' +
								'<span class="qq-upload-spinner" style=""></span>' +
								'<span class="qq-upload-size"></span>' +
								//'<a class="qq-upload-uploaded" href="javascript:void()">Uploading</a>' +
								'<a class="qq-upload-cancel" href="javascript:void()">Cancel</a>' +
								'<a class="qq-upload-failed-text">Failed</a>' +
						  '</li>',        
			
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
	
	'showPhoto':function(args){
		var url = args.action.replace(/&amp;/g,'&');
		var container = $('#'+args.target);
		var is_admin = args.admin == 1 ? 1 : 0;
		container.html(container.html()+"<div class='media_item'><img src='"+args.link+"' style='width:100px;height:100px'/><br/>"+args.file_name+"</div>");
		
		//var li = document.getElementById('photo_'+args.media_id);
		//var ar = qq.getByClass(li,'qq-upload-del2');
		
	},
}



function deleteAction(url,target,is_admin){
	if (is_admin == 1) {
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
					
					$.post(url,{target:target},onDeleteAction,'html');
				}
			});
		
	} else if (confirm('Do you want to delete?')) {
		$.post(url,{target:target},onDeleteAction,'html');
	}
}

function onDeleteAction(data){
	var JSONobject = JSON.parse(data);
	if(JSONobject.success == 1) {
		if(JSONobject.target != null) {
			jQuery('#'+JSONobject.target).hide();
		}
	} else {
		showMess('Error when deleting.');
	}
}



