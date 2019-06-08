function deleteUser(username, e) {
	$.ajax({
		url: 'index.php?url=userverwaltung',
		data:
		{
			action: 'deleteUser',
			name: username
		},
		type: 'post',
		success: function () {
			// remove the row
			$(e).closest('tr').remove();
		}
	});
}

function emailPasswordReset(useremail, username) {
	$.ajax({
		url: 'index.php?url=userverwaltung',
		data:
		{
			action: 'emailPasswordReset',
			email: useremail,
			name: username
		},
		type: 'post',
		success: function () {
			// display alert when its not allready displayed
			if ($('#emailAlert').length == 0) {
				$('h1').after('<div id="emailAlert" class="alert alert-success" role="alert">Passwort wurde erfolgreich resetet und per E-Mail gesendet!</div>')
			}
		}
	});
}

function changeStatus(userstatus, username, e) {
	console.log(userstatus);
	$.ajax({
		url: 'index.php?url=userverwaltung',
		data:
		{
			action: 'statusChange',
			status: userstatus,
			name: username
		},
		type: 'post',
		success: function () {
			// change status
			if ($(e).hasClass('text-success')) {
				$(e).removeClass();
				$(e).addClass('fas fa-thumbs-down text-danger');
				$(e).attr('onclick', 'changeStatus(0, ' + '\'' + username + '\'' + ', this' + ')');
			} else {
				$(e).removeClass();
				$(e).addClass('fas fa-thumbs-up text-success');
				$(e).attr('onclick', 'changeStatus(1, ' + '\'' + username + '\'' + ', this' + ')');
			}
		}
	});
}

