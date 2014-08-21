var wds_admin_product_list = {
	init : function() {
		this.bindLink();
		this.initTable();
	},
	initTable: function() {
		$('#product-table').dataTable( {
	        processing: true,
	        serverSide: true,
	        bAutoWidth: false,
			ajax: "/admin/product/product/getProcustsListData",
			columnDefs: [
				{
					"render": function ( data, type, row ) {
						return  '<img alt="" src="'+ data +'">';
					},
					"targets": 0
				},
			],
			columns: [
				{ "data": "img", "orderable": false, },
				{ "data": "title" },
				{ "data": "category" },
				{ "data": "price" },
				{ "data": "unit" },
				{ "data": "recommend" },
				{ 
					"data": null,
					"orderable": false,
					"render": function ( data, type, row ) {
						var editString = '<a href="/admin/product/product/edit/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-pencil"></i>编辑</a>';
						var deleteString = '<a href="/admin/product/product/delete/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-remove"></i>删除</a>';
						return editString + deleteString;
					}
				}
			]
		} );
	},
	bindLink : function() {
		$("a").on("click", function(e) {
			if ($(this).data("target")) {
				e.preventDefault();
				e.stopPropagation();

				var data = {
					id: $(this).closest('tr').data("id"),
					recommend: $(this).data("recommend")
				}
				core_ajax.getWithFlashMessager($(this).data("target"), data);
			}
		});
	}

};

$(function() {
	wds_admin_product_list.init();
});
