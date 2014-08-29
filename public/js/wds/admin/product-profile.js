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
                { "data": "total" },
                { 
                    "data": null,
                    "orderable": false,
                    "render": function ( data, type, row ) {
                        var nextString = '<button class="btn btn-xs btn-info"><i class="ace-icon fa fa-usd"></i>已付款</button>';
                        return nextString;
                    }
                }
			]
		} );
	},


};

$(function() {
    wds_admin_product_profile.init();
});
