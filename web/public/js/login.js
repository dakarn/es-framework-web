function sendToLogin()
{
	let form = document.forms.login.elements;

	$.ajax({
		url: "http://auth." + location.host + "/oauth/access-token",
		type: 'post',
		data: "CSRFToken=" + form[3].value  + "&login=" + form[0].value + "&password=" + form[1].value + "&clientId=" + location.host + "&clientSecret=" + location.host + "&site=" + location.host,
		success: function (data) {

			if (data.success) {
				let date = new Date(new Date().getTime() + 6000000);

				deleteCookie('JWT');

				document.cookie = 'JWT=' + data.data.accessToken + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();
				document.cookie = 'RFRT=' + data.data.refreshToken + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();
				document.cookie = 'EXP=' + data.data.expires_in + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();

				location.href = 'http://' + location.host;
			} else {
				alert('Не удалось получит токены!');
			}
		}
	});
}

function logout()
{
	let accessToken = getCookie('JWT');

	$.ajax({
		url: "http://auth." + location.host + "/oauth/logout",
		type: 'post',
		data: "accessToken=" + accessToken,
		success: function (data) {

			if (data.success) {
				deleteCookie('JWT');
				deleteCookie('RFRT');
				deleteCookie('EXP');

				location.href = 'http://' + location.host;
			}
		}
	});

	return false;
}

function logoutAllGadget()
{
	let accessToken = getCookie('JWT');

	$.ajax({
		url: "http://auth." + location.host + "/oauth/logout-all",
		type: 'post',
		data: "accessToken=" + accessToken,
		success: function (data) {

			if (data.success) {
				location.href = 'http://' + location.host;
			}
		}
	});

	return false;
}

function sendToRefreshToken()
{
	let refreshToken  = getCookie('RFRT');

	$.ajax({
		url: "http://auth." + location.host + "/oauth/refresh-token",
		type: 'post',
		data: "refreshToken=" + refreshToken + "&clientId=" + location.host + "&clientSecret=" + location.host + "&site=" + location.host,
		success: function (data) {

			if (data.success) {
				let date = new Date(new Date().getTime() + 6000000);

				deleteCookie('JWT');

				document.cookie = 'JWT=' + data.data.accessToken + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();
				document.cookie = 'RFRT=' + data.data.refreshToken + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();
				document.cookie = 'EXP=' + data.data.expires_in + '; domain=.' + location.host + '; path=/; expires=' + date.toUTCString();

				location.reload();
			}
		}
	});
}