function sendToLogin()
{
	let form = document.forms.login.elements;


	$.ajax({
		url: "http://auth.es-framework.dev.ru/oauth/access-token",
		type: 'post',
		data: "login=" + form[0].value + "&password=" + form[1].value + "&clientId=" + form[2].value + "&clientSecret=" + form[3].value + "&site=" + form[4].value,
		success: function (result) {

			let data = JSON.parse(result);

			if (data.success) {
				let date = new Date(new Date().getTime() + 100000000);

				document.cookie = 'JWT=' + data.data.accessToken + '; domain=.es-framework.dev.ru; path=/; expires=' + date.toUTCString();
				document.cookie = 'RFRT=' + data.data.refreshToken + '; domain=.es-framework.dev.ru; path=/; expires=' + date.toUTCString();
				document.cookie = 'EXP=' + data.data.expires_in + '; domain=.es-framework.dev.ru; path=/; expires=' + date.toUTCString();

				location.href = 'http://' + location.host;
			} else {
				alert('Не удалось получит токены!');
			}
		}
	});
}