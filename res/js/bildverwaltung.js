function applyShare(length, picId) {
	var checkedUsers = new Array;
	var uncheckedUsers = new Array;

	for (let index = 0; index < length; index++) {
		if ($('#checkbox' + index).prop('checked') == true) {
			checkedUsers.push($('#checkbox' + index).attr('name'));
		}
		if ($('#checkbox' + index).prop('checked') == false) {
			uncheckedUsers.push($('#checkbox' + index).attr('name'));
		}
	}

	$.ajax({
		url: 'index.php?url=bildverwaltung',
		data:
		{
			action: 'setSharedUsers',
			checkedusers: checkedUsers,
			uncheckedusers: uncheckedUsers,
			id: picId
		},
		type: 'post',
	});
}

function deleteImage(imageId) {
	$.ajax({
		url: 'index.php?url=bildverwaltung',
		data:
		{
			action: 'deleteImage',
			id: imageId
		},
		type: 'post',
		success: function () {
			$('[imgid=' + imageId + ']').remove();
		}
	});
}

function duplicateImage(imageId) {
	$.ajax({
		url: 'index.php?url=bildverwaltung',
		data:
		{
			action: 'duplicateImage',
			id: imageId
		},
		type: 'post',
		success: function (response) {
			var picture = response.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
			picture = JSON.parse(picture);

			// add uploaded picture
			var img = $('<img/>', {
				src: picture.location_thumb,
				class: 'img-fluid img-thumbnail pics',
				onclick: 'userImageModal(1, this)',
				alt: picture.name,
				imgid: picture.id,
			});

			$('#userImages').append(img);
		}
	});
}

function deleteSharedImage(imageId) {
	$.ajax({
		url: 'index.php?url=bildverwaltung',
		data:
		{
			action: 'deleteSharedImage',
			id: imageId
		},
		type: 'post',
		success: function () {
			$('[imgid=' + imageId + ']').remove();
		}
	});
}

function userImageModal(userOrShared, e) {
	$.ajax({
		url: 'index.php?url=bildverwaltung',
		data:
		{
			action: 'getImageData',
			id: $(e).attr('imgid')
		},
		type: 'post',
		success: function (response1) {
			// for some reason the response contains html code -> remove the html code -> so only the data remains
			var picture = response1.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
			picture = JSON.parse(picture);

			var img = $('<img/>', {
				src: picture.location,
				class: 'img-fluid',
				alt: picture.name
			});

			var row = $('<div/>', {
				class: 'row mt-3'
			});

			// define the list with the picture properties
			var list = '<div class="col"><ul class="list-group"><li class="list-group-item"><b>Name: </b>' + picture.name +
				'</li><li class="list-group-item"><b>Datum: </b>' + picture.date +
				'</li><li class="list-group-item"><b>Latitude: </b>' + picture.latitude +
				'</li><li class="list-group-item"><b>Longitude: </b>' + picture.longitude +
				'</li><li class="list-group-item"><b>User: </b>' + picture.user_username + '</li></ul></div>';

			// create modal for user image
			if (userOrShared) {
				$.ajax({
					url: 'index.php?url=bildverwaltung',
					data:
					{
						action: 'getUsers'
					},
					type: 'post',
					success: function (response2) {
						var users = response2.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
						users = JSON.parse(users);

						$.ajax({
							url: 'index.php?url=bildverwaltung',
							data:
							{
								action: 'getSharedUsers',
								id: $(e).attr('imgid')
							},
							type: 'post',
							success: function (response3) {
								var pictureUsers = response3.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
								pictureUsers = JSON.parse(pictureUsers);

								// define checkboxes that display to which user the image is shared
								var shareCol = $('<div class="col"><h4>Bild freigeben an</h4>');
								for (let index = 0; index < users.length; index++) {
									$(shareCol).append('<div class="input-group mb-2">' +
										'<div class="input-group-prepend"><div class="input-group-text"><input id="checkbox' + index + '" name="' + users[index].username + '" type="checkbox" aria-label="Checkbox for following text input"></div></div>' +
										'<input type="text" class="form-control" aria-label="Text input with checkbox" value="' + users[index].username + '" disabled></div>');
								} $(shareCol).append('</div>');

								// define buttons in modal footer for delte, copy and safe
								var btnGroup = $('<i class="fas fa-trash-alt text-left text-danger" data-dismiss="modal" onclick="deleteImage(' + picture.id +
									')"></i><i class="fas fa-copy text-left text-warning" data-dismiss="modal" onclick="duplicateImage(' + picture.id +
									')"></i><button type="button" class="btn btn-primary" data-dismiss="modal" onclick="applyShare(' + users.length + ', ' + picture.id + ')">Speichern</button>');

								$(row).append(list);
								$(row).append(shareCol);

								// set modal properties
								$('#modalTitle').text(picture.name);
								$("#modalBody").empty();
								$('#modalBody').append(img);
								$('#modalBody').append(row);
								$("#modalFooter").empty();
								$('#modalFooter').prepend(btnGroup);

								// check checkboxes if picture is shared to another user
								pictureUsers.forEach(function (user) {
									for (let index = 0; index < users.length; index++) {
										if (user.user_username == $('#checkbox' + index).attr('name')) {
											$('#checkbox' + index).prop('checked', true);
										}
									}
								});
							}
						});
					}
				});
			}

			// create Modal for shared Image
			else {
				// define buttons in modal footer for delte and Close
				var btnGroup = $('<i class="fas fa-trash-alt text-left text-danger" onclick="deleteSharedImage(' + picture.id + ')" data-dismiss="modal"></i></i><button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>');

				// set modal properties
				$(row).append(list);
				$('#modalTitle').text(picture.name);
				$("#modalBody").empty();
				$('#modalBody').append(img);
				$('#modalBody').append(row);
				$("#modalFooter").empty();
				$('#modalFooter').prepend(btnGroup);
			}
		}
	});
	// open modal
	$('#imageModal').modal('show');
}




