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
		success: function (response) {
			var check = response.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
			console.log(check);
		}
	});

}


function createModal(picture, users, shared) {
	//console.log(shared);
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

	// define checkboxes that display to which user the image is shared
	var shareCol = $('<div class="col"><h4>Bild freigeben an</h4>');
	for (let index = 0; index < users.length; index++) {
		$(shareCol).append('<div class="input-group mb-2">' +
			'<div class="input-group-prepend"><div class="input-group-text"><input id="checkbox' + index + '" name="' + users[index].username + '" type="checkbox" aria-label="Checkbox for following text input"></div></div>' +
			'<input type="text" class="form-control" aria-label="Text input with checkbox" value="' + users[index].username + '" disabled></div>');
	} $(shareCol).append('</div>');

	// define buttons in modal footer for delte, copy and safe
	var btnGroup = $('<i class="fas fa-trash-alt text-left text-danger"></i><i class="fas fa-copy text-left text-warning"></i><button type="button" class="btn btn-primary" data-dismiss="modal" onclick="applyShare(' + users.length + ', ' + picture.id + ')">Speichern</button>');

	$(row).append(list);
	$(row).append(shareCol);

	// set modal properteis
	$('#modalTitle').text(picture.name);
	$("#modalBody").empty();
	$('#modalBody').append(img);
	$('#modalBody').append(row);
	$("#modalFooter").empty();
	$('#modalFooter').prepend(btnGroup);

	// check checkboxes if picture is shared to another user
	shared.forEach(function (user) {
		for (let index = 0; index < users.length; index++) {
			if (user.user_username == $('#checkbox' + index).attr('name')) {
				$('#checkbox' + index).prop('checked', true);
			}
		}
	});

	// open modal
	$('#imageModal').modal('show');
}

function createSharedImageModal(picture) {
	//console.log(shared);
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

	// define buttons in modal footer for delte and Close
	var btnGroup = $('<i class="fas fa-trash-alt text-left text-danger"></i></i><button type="button" class="btn btn-primary" data-dismiss="modal">Schließen</button>');

	$(row).append(list);
	$('#modalTitle').text(picture.name);
	$("#modalBody").empty();
	$('#modalBody').append(img);
	$('#modalBody').append(row);
	$("#modalFooter").empty();
	$('#modalFooter').prepend(btnGroup);

	// open modal
	$('#imageModal').modal('show');

}

// ------------------------------------------------------------------------------------------------------------

function userImageModal(userOrShared, e) {
	// create modal for user image
	if (userOrShared) {
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
				var pictureResponse = response1.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
				//console.log(pictureResponse);
				pictureResponse = JSON.parse(pictureResponse);


				$.ajax({
					url: 'index.php?url=bildverwaltung',
					data:
					{
						action: 'getUsers'
					},
					type: 'post',
					success: function (response2) {
						var usersResponse = response2.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
						usersResponse = JSON.parse(usersResponse);

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
								// create the image modal with the information from the database
								createModal(pictureResponse, usersResponse, pictureUsers);
							}
						});
					}
				});
			}
		});
	}

	// create modal for shared image
	else {
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
				var pictureResponse = response1.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
				pictureResponse = JSON.parse(pictureResponse);
				createSharedImageModal(pictureResponse);
			}
		});
	}
}


