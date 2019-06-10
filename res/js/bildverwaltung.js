function applyShare(length, picId) {
	var checkedUsers = new Array;
	var check = false;
	var uncheck = false;

	for (let index = 0; index < length; index++) {
		if ($('#checkbox' + index)[0].checked) {
			checkedUsers.push($('#checkbox' + index).attr('name'));
			check = true;
		}
	}

	if (check) {
		$.ajax({
			url: 'index.php?url=bildverwaltung',
			data:
			{
				action: 'safeSharedPictures',
				users: checkedUsers,
				id: picId
			},
			type: 'post',
			success: function (response) {
				var check = response.replace(/<!DOCTYPE html[\s\S]*?<\/header>/, '');
				console.log(check);
			}
		});
	}

}


function createModal(picture, users) {
	var img = $('<img/>', {
		src: picture.location,
		class: 'img-fluid',
		alt: picture.name
	});

	var row = $('<div/>', {
		class: 'row mt-3'
	});

	var list = '<div class="col"><ul class="list-group"><li class="list-group-item"><b>Name: </b>' + picture.name +
		'</li><li class="list-group-item"><b>Datum: </b>' + picture.date +
		'</li><li class="list-group-item"><b>Latitude: </b>' + picture.latitude +
		'</li><li class="list-group-item"><b>Longitude: </b>' + picture.longitude +
		'</li><li class="list-group-item"><b>User: </b>' + picture.user_username + '</li></ul></div>';

	var shareCol = $('<div class="col"><h4>Bild freigeben an</h4>');
	for (let index = 0; index < users.length; index++) {
		$(shareCol).append('<div class="input-group mb-2">' +
			'<div class="input-group-prepend"><div class="input-group-text"><input id="checkbox' + index + '" name="' + users[index].username + '" type="checkbox" aria-label="Checkbox for following text input"></div></div>' +
			'<input type="text" class="form-control" aria-label="Text input with checkbox" value="' + users[index].username + '" disabled></div>');
	} $(shareCol).append('</div>');

	$(row).append(list);
	$(row).append(shareCol);

	var btnGroup = $('<i class="fas fa-trash-alt text-left text-danger"></i><i class="fas fa-copy text-left text-warning"></i><button type="button" class="btn btn-primary" data-dismiss="modal" onclick="applyShare(' + users.length + ', ' + picture.id + ')">Speichern</button>');

	$('#modalTitle').text(picture.name);
	$("#modalBody").empty();
	$('#modalBody').append(img);
	$('#modalBody').append(row);
	$("#modalFooter").empty();
	$('#modalFooter').prepend(btnGroup);
	$('#imageModal').modal('show');
}


function userImageModal(e) {
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
					//console.log(usersResponse);
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
							console.log(pictureUsers);
							//createModal(pictureResponse, usersResponse);
						}
					});
				}
			});
		}
	});
}



