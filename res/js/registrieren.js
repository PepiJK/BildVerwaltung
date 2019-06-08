$(document).ready(function () {
	$('#regForm').submit(function (event) {
		regValidatePwd(event);
	});
});

function regValidatePwd(event) {
	if ($('#dbValidate').length != 0) {
		$('#dbValidate').remove();
	}
	var pwd = $('#regPwd').val();
	var pwdWh = $('#regPwdWh').val();

	if (pwd != pwdWh) {
		if ($('#pwdError').length == 0) {
			$('h1').after('<div id="pwdError" class="alert alert-danger">Passwörter nicht ident!</div>');
		}
		event.preventDefault();
	}
}