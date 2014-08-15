var wds_admin_product_list = {
	init : function() {
		this.bindLink();
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
