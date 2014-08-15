var core_ajax = {
	postWithFlashMessager: function(url, data){
		$.post(url, data, function(html){
			$('.flash-messager-container').prepend(html);
		});
	},
	getWithFlashMessager: function(url, data){
		$.get(url, data, function(html){
			$('.flash-messager-container').prepend(html);
		});
	},
}