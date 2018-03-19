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
        idProperty: 'ID',
        remoteSort: true,
        fields: [
             'ID', 'FirstName', 'LastName', 'EmailAddress', 'Telephone', 'Level', 'Status', 'Edit', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/users/list.php'
        })
    });
    store.setDefaultSort('ID', 'desc'); 

// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.ID.value = \'{1}\';  document.frmEdit.Department.value = \'{0}\';  return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.ID);
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
        title:'Danh sách Người dùng [<a href="#" onclick = "document.frmEdit.ID.value = \'\'; return !showPopup(\'nameFieldPopup\', event);   " >Thêm mới</a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'ID',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Họ",
            dataIndex: 'FirstName',
            width: 100, 
            sortable: true			
        },{
            header: "Tên",
            dataIndex: 'LastName',
            width: 100, 
            sortable: true
		},{
            header: "Điện thoại",
            dataIndex: 'Telephone',
            width: 100, 
            sortable: true				
		 },{
            header: "Tên sử dụng",
            dataIndex: 'EmailAddress',
            width: 100, 
            sortable: true 
        },{            
            header: "Cấp độ",
            dataIndex: 'Level',
            width: 100,  
			align: 'center'			
		},{            
            header: "Tình trạng",
            dataIndex: 'Status',
            width: 100,  
			align: 'center'
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



 