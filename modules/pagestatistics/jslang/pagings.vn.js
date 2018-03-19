	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_id',
        remoteSort: true,
        fields: [
            'page_id', 'title', 'content', 'creation_time' , 'update_time', 'is_active' , 'sort_order' , 'Edit', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/Cms/showLists.php'
        })
    });
    store.setDefaultSort('page_id', 'ASC');  
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.page_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.page_id);
    }

    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Từ {0} đến {1} trong tổng số {2} ',
        emptyMsg: "Không có thông tin nào cả"          
    });

    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:778,
        height:500,
        title:'Danh Sách Tài Khoản [<a href="?module=Cms&action=addPage">Thêm mới</a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'page_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'page_id',
            width: 50, 
			align: 'center',
            sortable: true 
        },{
            header: "Tiêu Đề ",
            dataIndex: 'title',
            width: 150,  
            sortable: true			
		},{
            header: "Nội Dung",
            dataIndex: 'content',
            width: 300,  
            sortable: true 
		},{
            header: "Ngày Tạo",
            dataIndex: 'creation_time',
            width: 120,  
            sortable: true 			
		},{
            header: "Ngày Chỉnh Sửa",
            dataIndex: 'update_time',
            width: 120,  
            sortable: true 			
		},{
            header: "Trạng Thái",
            dataIndex: 'is_active',
            width: 100,  
            sortable: true 			
		},{
            header: "Vị Trí",
            dataIndex: 'sort_order',
            width: 50,  
            sortable: true 			
		},{            
            header: "Sửa",
            dataIndex: 'Edit',
            width: 50,  
			align: 'center'
		},{            
            header: "Xóa",
            dataIndex: 'Delete',
            width: 50,  
			align: 'center'
		 	
        }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:25}});
});



 