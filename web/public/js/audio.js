let Audio = (function ()
{
	const INTERVAL_PAUSE = 2000;
	const INDEX_MAX      = 4000;
	const ERROR_MAX      = 30;

	let audioList = [];
	let isPlay    = false;
	let index     = -1;
	let timer     = null;
	let tagAudio  = null;
	let notFound  = 0;

	function createAudioTag()
	{
		let body   = document.getElementById('audioContainer');
		let newTag = document.createElement('audio');
		newTag.id  = 'audioMP3';

		body.appendChild(newTag);
		tagAudio = document.getElementById('audioMP3');
	}

	function initTimer()
	{
		timer = setInterval(function () {
			nextList();
		}, INTERVAL_PAUSE);
	}

	function initEvents()
	{
		tagAudio.addEventListener('error', function () {

			if (notFound >= ERROR_MAX) {
				isPlay = false;
				index = 0;
				clearInterval(timer);
			}

			notFound++;
		});

		tagAudio.addEventListener('play', function () {

		});
	}

	function nextList()
	{
		if (index >= INDEX_MAX) {
			index = 0;
			clearInterval(timer);
			return;
		}

		++index;

		tagAudio.src = 'public/mp3/' + audioList[index] + '.mp3';
		document.getElementById('audioMP3').play();
	}

	return {

		addList: function(name)
		{
			audioList.push(name);
		},

		play: function ()
		{
			if (!isPlay) {
				isPlay = true;
				createAudioTag();
			}

			initTimer();
			initEvents();
			return false;
		}
	};

})();