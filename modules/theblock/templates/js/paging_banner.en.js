	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
var options;
var item = '';
var form;


Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'theblock_banner_id',
        remoteSort: true,
        fields: [
            'theblock_banner_id',
            'thumb_url_header',
			'thumb_url_footer', 
            'active',
			'active_value',
			'cms_page',
            'upload_time',
            'active',
            'theblock_id'
        ],		
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-banner')
        })
    });
    store.setDefaultSort('theblock_banner_id', 'ASC');
    store.load({params:{start:0, limit:20}});
	//POPUP
	var cms_options = new Ext.data.JsonStore({
		autoLoad: true,
		id:'page_id',
		root:'rows',
		fields:[
			{name:'page_id', type:'int'},
			{name:'title', type:'string'}
		],
		url: session.action_link.replace('[1]','action=get-page'),
		baseParams: {
			cmd:''
		}
	});
   //cms_options.load({params:{}});
	var theblock_store = new Ext.data.JsonStore({
		autoLoad: true,
		id:'property_id',
		root:'topics',
		fields:[
			{name:'property_id', type:'int'},
			{name:'owner', type:'string'}
		],
		url: session.action_link.replace('[1]','action=get-property'),
		baseParams: {
			cmd:''
		}
   });
	
   form = new Ext.FormPanel({
		frame: true,
		fileUpload:true,
		width: '100%',
		id: 'myform',
		layout: 'form',
		autoHeight: true,
		region: 'center',
		items:[
				  {
						xtype: 'fileuploadfield',
						emptyText: 'Select an image',
						fieldLabel: 'Image Header',
						buttonText: '',
						buttonCfg: {
							iconCls: 'upload-icon'
						},
						width: 448,
						name: 'link_header',
						id:'file-upload-header'
				  },
				  {
						xtype:'hidden',
						name:'target-header',
						id:'target-header',
						value:0
				  },				  
				  {
						xtype: 'fileuploadfield',
						emptyText: 'Select an image',
						fieldLabel: 'Image Footer',
						buttonText: '',
						buttonCfg: {
							iconCls: 'upload-icon'
						},
						width: 448,
						name: 'link_footer',
						id:'file-upload-footer'
				  },
				  {
						xtype:'hidden',
						name:'target-footer',
						id:'target-footer',
						value:0
				  },				  
				  {
						html: '<i><p>* You must upload with one of the following extensions: jpg, jpeg, gif, png</p><p>* File size less than 500Kb</p></i>',
						cls :'cus-panel',
						xtype: 'panel',
						layout:'auto'
				  },
				  				  
				  {
						xtype:'hidden',
						name:'id',
						id:'id',
						value:0
				  },
				  {
						allowBlank:true,
						id:'selector1',
						xtype:'superboxselect',
						fieldLabel: 'Page',
						emptyText: 'Select some page display this background',
						resizable: true,
						minChars: 2,
						name: 'cms',
						anchor:'100%',
						store: cms_options,
						mode: 'local',
						displayField: 'title',
						displayFieldTpl: '{title}',
						valueField: 'page_id',
						value: '',
						queryDelay: 0,
						triggerAction: 'all',
						listeners: {
							additem: function(bs,v){
							   item += v;
							   if (v == '306'){
								   Ext.getCmp('selector').enable();
								   //theblock_store.reload();
							   }
							},
							removeitem: function(bs,v){

							   if (v == '306'){
									Ext.getCmp('selector').disable();
									Ext.getCmp('selector').reset();
							   }
							   item.replace(v,'');
							}
						}
				  },
				  {
					   allowBlank:true,
					   id:'selector',
					   fieldLabel: 'Auction live',
					   emptyText: 'Select some property',
					   resizable: true,
					   anchor:'100%',
					   store: theblock_store,
					   mode: 'local',
					   displayField: 'owner',
					   displayFieldTpl: '#{property_id} - {owner}\'s property',
					   valueField: 'property_id',
					   queryDelay: 0,
					   triggerAction: 'all',
					   xtype:'superboxselect'
				  },
				  {
						xtype:'checkbox',
						id: 'rdActive',
						boxLabel: 'Active',
						checked : true,
						name:'active'
				  }
		   ],
		   buttons:[{
						text:'Save',
						icon : '/admin/resources/images/default/dd/save.png',
						handler:function(){
						   //var url = session.action_link.replace('[1]','action=upload-background');
							var cms = Ext.getCmp('selector1').getValue();
							var cms_value = item.length > 0?cms:'';
							var block_id = Ext.getCmp('selector').getValue();
						
							form.getForm().submit({
								method:'post',
								url: session.action_link.replace('[1]','action=upload-banner&cms='+cms_value+'&id='+Ext.getCmp('id').getValue()+'&block='+block_id),
								waitMsg: 'Uploading...',
								success: function(form, o) {
									var obj = Ext.util.JSON.decode(o.response.responseText);
									if (obj.error) {
										 Ext.Msg.show({title:'Error !', msg:obj.msg, icon:Ext.Msg.WARNING, buttons:Ext.Msg.OK});
									} else{
										Ext.Msg.show({title:'Success !', msg:'Save successful !', icon:Ext.Msg.INFO, buttons:Ext.Msg.OK});
										clearForm();
										store.load();
									}
									//options.hide();
								}
							});
						}
					},
					{
						text:'Cancel',
						icon : '/admin/resources/images/default/dd/cancel.png',
						handler:function(){
						  //form.getForm().reset();
						  //options.hide();
						  clearForm();
						}
					}
			]
	});
	options = new Ext.Window({title:'Add image', bodyStyle:'padding:10px', autoHeight:true, width:600, layout:'form', closable:false, items:[Ext.getCmp("myform")]});

    //create toolbar
    var tbar = new Ext.Toolbar({
        style: 'border:1px solid #99BBE8;'
    });

    tbar.add({
			    text : 'Add image',
			    icon : '/admin/resources/images/default/dd/drop-add.gif',
			    cls : 'x-btn-text-icon',
				handler : function() {
                    options.show();
                    Ext.getCmp('selector1').reset();
					Ext.getCmp('selector1').setValue('');
                    Ext.getCmp('selector').disable();
                    item = '';
			    }
			},'-',
			{
                text : 'Delete image',
                icon : '/admin/resources/images/default/dd/delete.png',
                cls : 'x-btn-text-icon',
                id:'btnRemove',
                disable: true,
                handler: function() {
                    var records = data.getSelectedRecords();
                    if (records.length != 0) {
                        var theblock_banner_id = [];
                        for (var i = 0; i < records.length; i++) {
                            theblock_banner_id.push(records[i].data.theblock_banner_id);
                        }
                        if (theblock_banner_id.length > 0) {
							outAction('multidelete',theblock_banner_id.join(','));
					    }
                    } else {
                        Ext.Msg.show({title:'Warning !', msg:'Please choose a image !', icon:Ext.Msg.WARNING, buttons:Ext.Msg.OK});
                    }
                }
    });
    //DATAVIEW
    var tpl = new Ext.XTemplate(
        '<tpl for=".">',
            '<div class="thumb-wrap" id="{theblock_banner_id}">',
            '<div class="thumb"><img src="{thumb_url_header}"><br/>(Banner header)</div>',
			'<div class="thumb" style="margin-top:2px;"><img src="{thumb_url_footer}"><br/>(Banner footer)</div>',
            '<div class="grid"><a href="javascript:void(0)" onclick="outAction(\'active\',\'{theblock_banner_id}\')">{active}</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="editBackground(\'{cms_page}\',{theblock_banner_id},\'{thumb_url_header}\',\'{thumb_url_footer}\',{active_value},\'{theblock_id}\')">Edit</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="outAction(\'delete\',\'{theblock_banner_id}\')">Delete</a></div></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
    );


    var data = new Ext.DataView({
        autoScroll: true,
        store: store,
        tpl: tpl,
        autoHeight: false,
        height: 400,
        multiSelect: true,
        overClass: 'x-view-over',
        itemSelector: 'div.thumb-wrap',
        emptyText: 'No images to display',
        style: 'border:1px solid #99BBE8; border-top-width: 0',
        plugins: [
                new Ext.DataView.DragSelector()
        ],
        listeners: {
            click: {
                fn: function() {
                    var selNode = data.getSelectedRecords();
                    if (selNode != null) {
                    } else {
                    }
                }
            },
            selectionchange: {
                fn: function(dv,nodes){
                    var l = nodes.length;
                    if (l == 0){
                    }else{
                    }
                }
            }
        }
    });
    //END
  
    //RENDER
    var panel = new Ext.Panel({
        id: 'images-view',
        frame: true,
        width: 1135,
        height: 500,
        autoHeight: true,
        layout: 'auto',
        title: 'Banner List',
        items: [tbar, data]
    });
    panel.render('topic-grid');
});

function ajaxAction(type, val, url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			theblock_banner_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			store.reload();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({title:'Warning !', msg:result.responseText, icon:Ext.Msg.WARNING, buttons:Ext.Msg.OK});
			}
			
		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});
}

function editBackground(cms, id, thumb_header, thumb_footer, active, theblock_id) {
    Ext.getCmp('id').setValue(id);
    if (theblock_id != null) {
        Ext.getCmp('selector').setValue(theblock_id);
    }
    var image_header = '<img src="'+thumb_header+'" style="margin:5px 0px 10px 107px;" width="40px" height ="40px" id="photoPreview-header"/>';
    $(image_header).insertBefore($('form.x-form input#target-header'));
	
    var image_footer = '<img src="'+thumb_footer+'" style="margin:5px 0px 10px 107px;" width="40px" height ="40px"  id="photoPreview-footer"/>';
    $(image_footer).insertBefore($('form.x-form input#target-footer'));
	
    var arr = {'rdActive':active};
    $.each(arr,function(key,value){
        if (value == 1) $('#'+key).attr('checked',true);
        else $('#'+key).removeAttr('checked');
    });
    Ext.getCmp('selector1').setValue(cms);
    options.show();
}

function clearForm() {
	//remove
	Ext.getCmp('selector').reset();
	Ext.getCmp('selector1').reset();
	Ext.getCmp('id').setValue(0);
	Ext.getCmp('file-upload-header').reset();
	Ext.getCmp('file-upload-footer').reset();
	$('#rdActive').attr('checked',true);
	//hide theblock_id
	Ext.getCmp('selector').disable();
	$('form.x-form').find('#photoPreview-header').remove();
	$('form.x-form').find('#photoPreview-footer').remove();
	options.hide();
}
