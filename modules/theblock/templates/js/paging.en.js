	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
var store_agent = null;
var options,options_agent,form_agent;
var item = '';
var form;


Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'background_id',
        remoteSort: true,
        fields: [
            'background_id',
            'link',
            'active',
            'cms_page',
            'upload_time',
            'thumb_url',
            'repeat',
            'fixed',
            'active',
            'background_color',
            'active_value',
            'theblock_id'
        ],		
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-background')
        })
    });
    store.setDefaultSort('background_id', 'ASC');
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
				{name:'owner', type:'string'},
                {name:'title', type:'string'}
             ],
			url: session.action_link.replace('[1]','action=get-property'),
            baseParams: {
		 		cmd:''
		 	}
       });
      /* page = new Ext.ux.form.SuperBoxSelect({


       });*/
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
                            fieldLabel: 'Image',
                            buttonText: '',
                            buttonCfg: {
                                iconCls: 'upload-icon'
                            },
                            width: 448,
                            name: 'img',
                            id:'file-upload'
                      },{
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
                                          if (v == '27'){
                                               Ext.getCmp('selector').enable();
                                               //theblock_store.reload();
                                          }
                                        },
                                        removeitem: function(bs,v){

                                           if (v == '27'){
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
                               displayField: 'title',
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
					  },
                      { xtype:'fieldset',
				        title: 'Advance style',
				        checkboxToggle: true,
				        autoHeight:true,
				        items:[{
                                xtype: 'colorpickerfield',
                                fieldLabel: 'Background color',
                                name: 'background_color',
                                value: '#FFFFFF',
                                ref: 'color',
                                id: 'txtColor'
                              },{
                                xtype:'checkbox',
                                id: 'rdRepeat',
                                boxLabel: 'Repeat',
                                checked : false,
                                name:'repeat'
                              },{
                                xtype:'checkbox',
                                id: 'rdFixed',
                                boxLabel: 'Disable scroll background',
                                checked : false,
                                name:'fixed'

                              }]
                      }
                   ],
               buttons:[{text:'Save',
                                            icon : '/admin/resources/images/default/dd/save.png',
                                               handler:function(){
                                                       //var url = session.action_link.replace('[1]','action=upload-background');
                                                        var cms = Ext.getCmp('selector1').getValue();
                                                        var cms_value = item.length > 0?cms:'';
                                                        var block_id = Ext.getCmp('selector').getValue();


                                                        form.getForm().submit({
                                                            method:'post',
                                                            url: session.action_link.replace('[1]','action=upload-background&cms='+cms_value+'&id='+Ext.getCmp('id').getValue()+'&block='+block_id),
                                                            waitMsg: 'Uploading...',
                                                            success: function(form, o) {
                                                                var obj = Ext.util.JSON.decode(o.response.responseText);
                                                                if (obj.error) {
                                                                     Ext.Msg.show({
                                                                        title:'Error !'
                                                                        ,msg:obj.msg
                                                                        ,icon:Ext.Msg.WARNING
                                                                        ,buttons:Ext.Msg.OK

                                                                    });
                                                                } else{
                                                                    Ext.Msg.show({
                                                                        title:'Success !'
                                                                        ,msg:'Save successful !'
                                                                        ,icon:Ext.Msg.INFO
                                                                        ,buttons:Ext.Msg.OK

                                                                    });
                                                                    clearForm();
                                                                    store.load();
                                                                }
                                                                //options.hide();
                                                            }
                                                        });
                                               }
                                           },
                                           {text:'Cancel',
                                            icon : '/admin/resources/images/default/dd/cancel.png',
                                               handler:function(){
                                                  //form.getForm().reset();
                                                  //options.hide();
                                                  clearForm();
                                               }
                                           }

                                       ]

       });
         options = new Ext.Window({
                   title:'Add image',
                   bodyStyle:'padding:10px',
                   autoHeight:true,
                   width:600,
                   layout:'form',
                   closable:false,
                   items:[Ext.getCmp("myform")]
                });
                //radio.items = result.data;
                //options.doLayout();

        //END
    //end

    //create toolbar
    var tbar = new Ext.Toolbar({
        style: 'border:1px solid #99BBE8;'
    });

    tbar.add({
			    text : 'Add image',
			    icon : '/admin/resources/images/default/dd/drop-add.gif',
			    cls : 'x-btn-text-icon',
				handler : function() {
                    var a = Ext.getCmp('tab').getActiveTab();
                    var idx = Ext.getCmp('tab').items.indexOf(a);
                    if (idx == 0){//ibb
                        options.show();
                        Ext.getCmp('selector1').reset();
                        Ext.getCmp('selector').disable();
                        item = '';
                    }else{
                        options_agent.show();
                    }

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
                        var background_id = [];
                        for (var i = 0; i < records.length; i++) {
                            background_id.push(records[i].data.background_id);
                        }
                        if (background_id.length > 0) {
							outAction('multidelete',background_id.join(','));
					    }
                    }else{
                        Ext.Msg.show({
                            title:'Warning !'
                            ,msg:'Please choose a image !'
                            ,icon:Ext.Msg.WARNING
                            ,buttons:Ext.Msg.OK});
                    }
                }
    });
    //DATAVIEW
    var tpl = new Ext.XTemplate(
        '<tpl for=".">',
            '<div class="thumb-wrap" id="{background_id}">',
            '<div class="thumb"><a class="photoThumbDiv"><i style="background-image: url(\'{thumb_url}\');" class="photoThumbImg"></i></a></div>',
            '<div class="grid"><a href="javascript:void(0)" onclick="outAction(\'active\',\'{background_id}\')">{active}</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="editBackground(\'{cms_page}\',{background_id},\'{thumb_url}\',\'{background_color}\',{active_value},{fixed},{repeat},\'{theblock_id}\')">Edit</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="outAction(\'delete\',\'{background_id}\')">Delete</a></div></div>',
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
                         /*Ext.Msg.show({
                            title:'Warning !'
                            ,msg:'Please choose a image !'
                            ,icon:Ext.Msg.WARNING
                            ,buttons:Ext.Msg.OK
                        });*/
                       //Ext.getCmp('btnRemove').enable();
                    } else {
                        //Ext.getCmp('btnRemove').disable();
                    }
                }
            },
            selectionchange: {
                fn: function(dv,nodes){
                    var l = nodes.length;
                    if (l == 0){

                        //Ext.getCmp('btnRemove').disable();
                    }else{
                       // Ext.getCmp('btnRemove').enable();
                    }
                }
            }
        }
    });
    //END

    /*------------------------AGENT--------------------------------*/
    /*var storeCompany = new Ext.data.JsonStore({
            autoLoad: true,
		 	id:'agent_id',
			root:'rows',
		 	fields:[
			 	{name:'agent_id', type:'int'},
				{name:'company_name', type:'string'}
		 	],
			url: session.action_link.replace('[1]','action=get-company'),
		});
    storeCompany.load({params:{start:0, limit:20}});*/
    form_agent = new Ext.FormPanel({
            frame: true,
            fileUpload:true,
            width: '100%',
            id: 'form_agent',
            layout: 'form',
            autoHeight: true,
            region: 'center',
            items:[
                      {
                            xtype: 'fileuploadfield',
                            emptyText: 'Select an image',
                            fieldLabel: 'Image',
                            buttonText: '',
                            buttonCfg: {
                                iconCls: 'upload-icon'
                            },
                            width: 448,
                            name: 'img',
                            id:'file-upload-agent'
                      },{
                            html: '<i><p>* You must upload with one of the following extensions: jpg, jpeg, gif, png</p><p>* File size less than 500Kb</p></i>',
                            cls :'cus-panel',
                            xtype: 'panel',
                            layout:'auto'
                      },
                      {
                            xtype:'hidden',
                            name:'id',
                            id:'id-agent',
                            value:0
                      },
                      {
                            triggerAction: 'all',
                            name:'type',
                            id: 'cmbType',
                            fieldLabel: 'Position',
                            editable: false,
                            xtype: 'combo',
                            store : [
                                ['top','Top'],
                                ['left','Left'],
                                ['right','Right']
                            ],
                            emptyText: 'Select position',
                            width: 250,
                            forceSelection:true
                      },
                      {
                            triggerAction: 'all',
                            name:'agent_id',
                            id: 'cmbCompany',
                            mode: 'local',
                            fieldLabel: 'Company',
                            editable: false,
                            xtype: 'combo',
                            store : new Ext.data.JsonStore({
                                autoLoad: true,
                                fields:[
                                    {name:'agent_id', type:'int'},
                                    {name:'company_name', type:'string'}
                                ],
                                url: session.action_link.replace('[1]','action=get-company')
                            }),
                            emptyText: 'Select company',
                            width: 250,
                            valueField:'agent_id'
                            ,displayField:'company_name',
                            forceSelection:true
                      },
                      {
						xtype:'checkbox',
						id: 'rdActive',
						boxLabel: 'Active',
						checked : true,
                        name:'active'
					  },
                      { xtype:'fieldset',
				        title: 'Advance style',
				        checkboxToggle: true,
				        autoHeight:true,
				        items:[{
                                xtype: 'colorpickerfield',
                                fieldLabel: 'Background color',
                                name: 'background_color',
                                value: '#FFFFFF',
                                ref: 'color',
                                id: 'txtColor-agent'
                              },{
                                xtype:'checkbox',
                                id: 'rdRepeat-agent',
                                boxLabel: 'Repeat',
                                checked : false,
                                name:'repeat'
                              },{
                                xtype:'checkbox',
                                id: 'rdFixed-agent',
                                boxLabel: 'Disable scroll background',
                                checked : false,
                                name:'fixed'
                              }]
                      }
                   ],
               buttons:[{text:'Save',
                                            icon : '/admin/resources/images/default/dd/save.png',
                                               handler:function(){
                                                        form_agent.getForm().submit({
                                                            method:'post',
                                                            url: session.action_link.replace('[1]','action=upload-background&type='+Ext.getCmp('cmbType').getValue()+'&agent_id='+Ext.getCmp('cmbCompany').getValue()),
                                                            waitMsg: 'Uploading...',
                                                            success: function(form, o) {
                                                                var obj = Ext.util.JSON.decode(o.response.responseText);
                                                                if (obj.error) {
                                                                     Ext.Msg.show({
                                                                        title:'Error !'
                                                                        ,msg:obj.msg
                                                                        ,icon:Ext.Msg.WARNING
                                                                        ,buttons:Ext.Msg.OK

                                                                    });
                                                                } else{
                                                                    Ext.Msg.show({
                                                                        title:'Success !'
                                                                        ,msg:'Save successful !'
                                                                        ,icon:Ext.Msg.INFO
                                                                        ,buttons:Ext.Msg.OK

                                                                    });
                                                                    clearFormAgent();
                                                                    store_agent.load();
                                                                }
                                                                //options.hide();
                                                            }
                                                        });
                                               }
                                           },
                                           {text:'Cancel',
                                            icon : '/admin/resources/images/default/dd/cancel.png',
                                               handler:function(){
                                                  clearFormAgent();
                                               }
                                           }

                                       ]

       });
         options_agent = new Ext.Window({
                   title:'Add image',
                   bodyStyle:'padding:10px',
                   autoHeight:true,
                   width:600,
                   layout:'form',
                   closable:false,
                   items:[Ext.getCmp("form_agent")]
                });
        //END
    //end


    var tpl_agent = new Ext.XTemplate(
        '<tpl for=".">',
            '<div class="thumb-wrap" id="{background_id}">',
            '<div class="thumb"><a class="photoThumbDiv" style="background: {background_color}"><i style="background-image: url(\'{thumb_url}\');" class="photoThumbImg"></i></a><br/>({type_name})</div>',
            '<div class="grid"><a href="javascript:void(0)" onclick="outAction(\'active\',\'{background_id}\')">{active}</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="editBackgroundAgent({background_id})">Edit</a>',
            '<span>|</span>',
            '<a href="javascript:void(0)" onclick="outAction(\'delete\',\'{background_id}\')">Delete</a></div></div>',
        '</tpl>',
        '<div class="x-clear"></div>'
    );

     // create the Data Store
    store_agent = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'background_id',
        remoteSort: true,
        fields: [
            'background_id',
            'link',
            'active',
            'cms_page',
            'upload_time',
            'thumb_url',
            'repeat',
            'fixed',
            'background_color',
            'active_value',
            'agent_id',
            'type',
            'type_name'
        ],
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-background-agent')
        })
    });
    store_agent.setDefaultSort('background_id', 'ASC');
    store_agent.load({params:{start:0, limit:20}});

    var data_agent = new Ext.DataView({
        autoScroll: true,
        store: store_agent,
        tpl: tpl_agent,
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
    /*-------------------------------------------------------------*/
  
    //RENDER
    var panel = new Ext.Panel({
        id: 'images-view',
        frame: true,
        width: 1135,
        height: 500,
        autoHeight: true,
        layout: 'auto',
        title: 'Background List',
        items: [tbar,
            {
                xtype: 'tabpanel',
                id:'tab',
                region: 'center',
                margins: '5 5 5 0',
                tabPosition: 'bottom',
                activeTab: 0,
                items: [
                    {
                        // Panels that are used as tabs do not have title bars since the tab
                        // itself is the title container.  If you want to have a full title
                        // bar within a tab, you can easily nest another panel within the tab
                        // with layout:'fit' to acheive that:
                        title: 'IBB Backgrounds',
                        id:'tab-ibb',
                        layout: 'fit',
                        items: [data]
                    },
                    {
                        title: 'Agent Backgrounds',
                        id:'tab-agent',
                        layout: 'fit',
                        items: [data_agent]
                    }
                ]
            }]
    });
    panel.render('topic-grid');

});
function ajaxAction(type,val,url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			background_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			var a = Ext.getCmp('tab').getActiveTab();
            var idx = Ext.getCmp('tab').items.indexOf(a);
            if (idx == 0){
                store.reload();
            }else{
                store_agent.reload();
            }
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({
                    title:'Warning !'
                    ,msg:result.responseText
                    ,icon:Ext.Msg.WARNING
                    ,buttons:Ext.Msg.OK
	            });
			}
			
		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});
}

function editBackground(cms,id,thumb_url,background_color,active,fixed,repeat,theblock_id){
    Ext.getCmp('id').setValue(id);
    if (theblock_id != null) {
        Ext.getCmp('selector').setValue(theblock_id);
    }
    var image = '<img src="'+thumb_url+'" style="margin:5px 0px 10px 107px;" id="photoPreview"/>';
    $(image).insertBefore($('form.x-form input#id'));
    var arr = {'rdActive':active,'rdFixed':fixed,'rdRepeat':repeat};
    $.each(arr,function(key,value){
        if (value == 1) $('#'+key).attr('checked',true);
        else $('#'+key).removeAttr('checked');
    });
    Ext.getCmp('selector1').setValue(cms);
    options.show();
    Ext.getCmp('txtColor').setValue(background_color);
}
function clearForm(){
            //remove
            Ext.getCmp('selector').reset();
            Ext.getCmp('selector1').reset();
            Ext.getCmp('id').setValue(0);
            Ext.getCmp('file-upload').reset();
            Ext.getCmp('txtColor').setValue('#FFFFFF');
            $('#rdActive').attr('checked',true);
            $('#rdRepeat').removeAttr('checked');
            $('#rdFixed').removeAttr('checked');


            //hide theblock_id
            Ext.getCmp('selector').disable();
            $('form.x-form').find('#photoPreview').remove();
            options.hide();
}

function editBackgroundAgent(background_id){
    var url = session.action_link.replace('[1]','action=get-background');
    $.post(url,{id:background_id},function(data){
               var result = jQuery.parseJSON(data);
               if (result.success){
                   Ext.getCmp('id-agent').setValue(result.background_id);
                    var image = '<img src="'+result.thumb_url+'" style="margin:5px 0px 10px 107px;" id="photoPreview"/>';
                    $(image).insertBefore($('form.x-form input#id-agent'));
                    var arr = {'rdActive-agent':result.active,'rdFixed-agent':result.fixed,'rdRepeat-agent':result.repeat};
                    $.each(arr,function(key,value){
                        if (value == 1) $('#'+key).attr('checked',true);
                        else $('#'+key).removeAttr('checked');
                    });
                   Ext.getCmp('cmbType').setValue(result.type);
                   Ext.getCmp('cmbCompany').setValue(result.agent_id);
                   options_agent.show();
                   Ext.getCmp('txtColor-agent').setValue(result.background_color);
               }
            },'html');
}
function clearFormAgent(){
            //remove
    Ext.getCmp('cmbType').setValue('');
    Ext.getCmp('cmbCompany').setValue('');
    Ext.getCmp('id-agent').setValue(0);
    Ext.getCmp('file-upload-agent').reset();
    Ext.getCmp('txtColor-agent').setValue('#FFFFFF');
    $('#rdActive-agent').attr('checked', true);
    $('#rdRepeat-agent').removeAttr('checked');
    $('#rdFixed-agent').removeAttr('checked');


    //hide theblock_id
    $('form.x-form').find('#photoPreview').remove();
    options_agent.hide();

}




 