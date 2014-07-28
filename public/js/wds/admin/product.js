var wds_admin_product = {
	init: function(){
		this.initDropZone();
	},
	
	initDropZone: function(){
		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone("div.dropzone", { 
			url: "/product/product/uploadimage",
		    paramName: "file", // The name that will be used to transfer the file
		    maxFilesize: 0.5, // MB

			addRemoveLinks : true,
			dictDefaultMessage : $('#dropzone_dictDefaultMessage').html(),
			dictResponseError: 'Error while uploading file!',
			
			//change the previewTemplate to use Bootstrap progress bars
			previewTemplate: $('#dropzone_previewTemplate').html(),
		  
		});
		myDropzone.on("success", function(file, response){
			console.log(file);
		});
		
	}
};

$(function(){
	wds_admin_product.init();
});
