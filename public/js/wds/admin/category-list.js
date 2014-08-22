var wds_admin_category_list = {
	init : function() {
		this.initTable();
	},
	initTable: function() {
		$('#category-table').dataTable( {
	        processing: true,
	        serverSide: true,
	        bAutoWidth: false,
			ajax: "/admin/product/category/getCategoriesListData",
			columns: [
				{ "data": "title" },
                { 
                    "data": null,
                    "orderable": false,
                    "render": function ( data, type, row ) {
                        var editString = '<a href="/admin/product/category/edit/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-pencil"></i>编辑</a>';
                        var deleteString = '<a href="/admin/product/category/delete/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-remove"></i>删除</a>';
                        return editString + deleteString;
                    }
                }
			]
		} );
	},


};

$(function() {
    wds_admin_category_list.init();
});
