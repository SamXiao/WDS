var wds_admin_product = {
	elmDropzone: null,
	init: function(){
		this.initDropZone();
		this.initUploadedFiles();
		this.initEvents();
	},
	initEvents: function(){
		var form = $('#product_form');
		$(form).on('submit', function(e){
			$(".dropzone .dz-details").each(function(){
				var input = '<input type="hidden" name="product_images[]" value="' + $(this).attr("data-dz-id") + '">';
				$(form).append(input);
			})
		});
	},
	
	initDropZone: function(){
		Dropzone.autoDiscover = false;
		this.elmDropzone = new Dropzone("div.dropzone", { 
			url: "/product/product/uploadimage",
		    paramName: "file", // The name that will be used to transfer the file
		    maxFilesize: 0.5, // MB

			addRemoveLinks : true,
			dictDefaultMessage : $('#dropzone_dictDefaultMessage').html(),
			dictResponseError: 'Error while uploading file!',
			
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: $('#dropzone_previewTemplate').html(),
		  
		});
		this.elmDropzone.on("success", function(file, response){
			$(file.previewTemplate).find('.dz-details').attr('data-dz-id', response.id);
		});
	
		this.elmDropzone.on("addedfile", function(file) {
		  console.log(file);
		});
		
	},
	
	initUploadedFiles: function(){
		var files = $("#dropzone_uploadedFiles").html();
		files = $.parseJSON(files);
		var elmDropzone = this.elmDropzone;
		$.each(files, function( index, value ){
			var file = { 
                id: value.id,
                name: value.name,
            }
			elmDropzone.emit("addedfile", file);
			elmDropzone.emit("thumbnail", file, value.thumbnail_uri);
		})
		
	}
};

$(function(){
	wds_admin_product.init();
});
