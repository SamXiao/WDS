var wds_admin_product_profile = {
    options: {
        productId: 0
    },    
	init : function() {
		this.initTable();
	},
	initTable: function() {
	    var self = this;
		$('#buyer-table').dataTable( {
	        processing: true,
	        serverSide: true,
	        bAutoWidth: false,
	    	searching: false,
			lengthChange: false,
			info: false,
			ajax: "/admin/product/profile/getBuyerData/" + self.options.productId,
			columns: [
				{ "data": "buyer_weixin" },
                { "data": "quantity" },
                { 
                    "data": null,
                    "orderable": false,
                    "render": function ( data, type, row ) {
                        var editString = '<a href="/admin/product/category/edit/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-pencil"></i>编辑</a>';
                        var deleteString = '<a href="/admin/product/category/delete/' + row.DT_RowId + '"> <i class="ace-icon glyphicon glyphicon-remove"></i>删除</a>';
                        return editString;
                    }
                }
			]
		} );
	},


};

$(function() {
    wds_admin_product_profile.init();
});
