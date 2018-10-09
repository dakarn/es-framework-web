function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

function deleteCookie(name)
{
	document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1999 00:00:01 GMT;';
}

function now()
{
	return new Date().getTime()/1000;
}

window.addEventListener('load', function () {

	let refreshToken  = getCookie('RFRT');
	let JWToken       = getCookie('JWT');
	let expires       = getCookie('EXP');

	if (expires && refreshToken && JWToken) {
		if (expires < now()) {
			sendToRefreshToken();
		}
	}
});