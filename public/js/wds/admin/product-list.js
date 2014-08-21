var wds_admin_product_list = {
	init : function() {
		this.initTable();
	},
	initTable: function() {
		$('#product-table').dataTable( {
	        processing: true,
	        serverSide: true,
	        bAutoWidth: false,
			ajax: "/admin/product/product/getProcustsListData",
			order: [[ 1, "desc" ]],
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
					    var shareString = '<a data-target="#qrcodeModal" data-method="modal-qrcode" data-toggle="modal" data-text="/p/' + row.DT_RowId + '"><i class="ace-icon glyphicon glyphicon-pencil"></i>分享</a>';
					    var editString = '<a href="/admin/product/product/edit/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-pencil"></i>编辑</a>';
						var deleteString = '<a href="/admin/product/product/delete/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-remove"></i>删除</a>';
						var recommendString = '';
						if(row.recommend == 1){
						    recommendString = '<a data-target="/admin/product/product/recommend" data-method="ajax" data-id="' + row.DT_RowId + '" data-recommend="0" ><i class="ace-icon glyphicon glyphicon-pencil"></i>取消推荐</a>';
						}else{
						    recommendString = '<a data-target="/admin/product/product/recommend" data-method="ajax" data-id="' + row.DT_RowId + '" data-recommend="1" ><i class="ace-icon glyphicon glyphicon-pencil"></i>推荐</a>';
						}
						// data-toggle="modal" data-target="#myModal"
						return shareString + recommendString + editString + deleteString;
					}
				}
			]
		} );
	},


};

$(function() {
	wds_admin_product_list.init();
});
