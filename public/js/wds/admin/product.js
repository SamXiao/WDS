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
		    maxFilesize: 5, // MB
		    params: {
		    	product_id: $("input[name='id']").val()
		    },
		    addRemoveLinks : false,
			dictDefaultMessage : $('#dropzone_dictDefaultMessage').html(),
			dictResponseError: 'Error while uploading file!',
			
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: $('#dropzone_previewTemplate').html(),
		  
		});
		this.elmDropzone.on("success", function(file, response){
			$(file.previewTemplate).find('.dz-details').attr('data-dz-id', response.id);
		});
	
		this.elmDropzone.on("addedfile", function(file) {
			if(file.id){
				$(file.previewTemplate).find('.dz-details').attr('data-dz-id', file.id);
			}
			
	        // Create the remove button
	        var removeButton = Dropzone.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove="">删除</a>"');


	        // Capture the Dropzone instance as closure.
	        var _this = this;

	        // Listen to the click event
	        removeButton.addEventListener("click", function(e) {
	          // Make sure the button click doesn't submit the form:
	          e.preventDefault();
	          e.stopPropagation();
	          
	          var button = this;

	        
	          // If you want to the delete the file on the server as well,
	          // you can do the AJAX request here.
	          $.post('/product/product/removeImage', { id: $(button).parent().find('.dz-details').attr('data-dz-id')}, function(){
	        	  // Remove the file preview.
		          _this.removeFile(file);
	          });
	        });

	        // Add the button to the file preview element.
	        file.previewElement.appendChild(removeButton);
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
                size: 1024
            }
			elmDropzone.emit("addedfile", file);
			elmDropzone.emit("thumbnail", file, value.thumbnail_uri);
		});
		elmDropzone.maxFilesize -= files.length;
	}
};

$(function(){
	wds_admin_product.init();
});
