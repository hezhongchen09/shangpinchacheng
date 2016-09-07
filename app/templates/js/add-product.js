$(function () {
	$("#status").bootstrapSwitch();
	$("#hot").bootstrapSwitch();

	var imagesCount = 0;
	$("#description-add-button").click(function(){
		imagesCount++;
		var descriptionDiv = '<div class="description-div" description-id="'+imagesCount+'" id="description-div'+imagesCount+'">'+
								'<div id="image-preview-div'+imagesCount+'" style="display: none">'+
									'<img id="preview-img'+imagesCount+'" src="noimage">'+
								'</div>'+
								'<div id="message'+imagesCount+'"></div>'+
								'<div class="form-group">'+
									'<input type="file" name="file" id="file'+imagesCount+'" required>'+
								'</div>'+
								'<div><textarea class="form-textarea-control" id="image-description" placeholder="图片描述"></textarea>'+
								'<button type="button" class="close" id="description-remove-button'+imagesCount+'">'+
									'<span aria-hidden="true">&times;</span>'+
									'<span class="sr-only">Close</span>'+
								'</button>'+
							'</div>';
		$("#description").append($(descriptionDiv));

		$("#description-remove-button"+imagesCount).click(function(){
			$(this).parent().remove();
		});

		var maxsize = 500*1024;
		$('#file'+imagesCount).change(function() {
			var descriptionId = $(this).parent().parent().attr("description-id");

			$('#message'+descriptionId).empty();

			var file = this.files[0];
			var match = ["image/jpeg", "image/png", "image/jpg"];

			if (!file) {
				noPreview(descriptionId);

				return false;
			}

			if (file.type!=match[0] && file.type!=match[1] && file.type!=match[2]){
				noPreview(descriptionId);
				$('#message'+descriptionId).html('<div class="alert alert-warning" role="alert">文件格式错误，支持的文件格式：JPG、JPEG、PNG。</div>');

				return false;
			}

			if (file.size>maxsize){
				noPreview(descriptionId);
				$('#message'+descriptionId).html('<div class=\"alert alert-danger\" role=\"alert\">图片大小为' + (file.size/1024).toFixed(2) + 'KB，已超出最大限制（' + (maxsize/1024).toFixed(2) + 'KB）。</div>');

				return false;
			}

			var reader = new FileReader();
			reader.onload = function(e){
				$('#file'+descriptionId).css("color", "green");
				$('#image-preview-div'+descriptionId).css("display", "block");
				$('#preview-img'+descriptionId).attr('src', e.target.result);
			};
			reader.readAsDataURL(this.files[0]);
		});
	});

	function noPreview(id) {
		$('#image-preview-div'+id).css("display", "none");
		$('#preview-img'+id).attr('src', 'noimage');
	}
});