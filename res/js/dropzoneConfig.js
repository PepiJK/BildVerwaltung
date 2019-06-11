Dropzone.options.dropzoneForm = {
	maxFilesize: 4, // MB
	addRemoveLinks: true,
	acceptedFiles: "image/*", // Accept images only
	success: function (file, responseText) {
		// for some reason the response contains html code -> remove the html code -> so only json remains
		var response = responseText.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
		console.log(response);
		response = JSON.parse(response);

		// remove alert info if it exists
		if ($('#userImagesAlert').length != 0) {
			$('#userImagesAlert').remove();
		}

		// add uploaded picture
		var img = $('<img/>', {
			src: response.fileLocationThumb,
			class: 'img-fluid img-thumbnail pics',
			onclick: 'userImageModal(1, this)',
			alt: response.fileName,
			imgid: response.id,
		});

		$('#userImages').append(img);

	}
};