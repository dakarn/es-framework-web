var hide = false;

function filterText(name, begin, end, comma)
{
	var text = $("textarea[name='" + name + "']").val(), list = text.split('\n');
	$("textarea[name='" + name + "']").val('');

	for (var k in list) {

		var res = '';
		var i   = 0;

		list[k] = list[k].replace(/\[(.*)\]/g, '');

		while (list[k].length > i) {

			if (begin < list[k][i].charCodeAt(0) && list[k][i].charCodeAt(0) < end) {
				res += list[k][i].trim();
			}

			if (comma == 'comma' && list[k][i] == ',' || list[k][i] == ' ') res += list[k][i];

			i++;
		}

		$("textarea[name='" + name + "']").val($("textarea[name='" + name + "']").val() + res.trim() + (k < list.length - 1 ? '\n' : '') + '');
	}
}


function filter()
{
	filterText('AddWord[text]', 96, 123, 0);
	filterText('AddWord[translate]', 1020, 1113, 'comma');

	return false;
}


$("#several").click(function(e)
{
	if ($(this).attr("data-fun") == 'several') {

		$(this).html("Добавить по одному");
		$(this).attr("data-fun", "one");

		var newbuff = $("#contentSev").html();

		$("#contentSev").html($("#buffer").html());
		$("#buffer").html(newbuff);

		$(".several").val("several");

	} else if ($(this).attr("data-fun") == 'one') {

		$(this).html("Добавить несколько слов сразу");
		$(this).attr("data-fun", "several");

		var newbuff = $("#contentSev").html();

		$("#contentSev").html($("#buffer").html());
		$("#buffer").html(newbuff);

		$(".several").val("one");

	}

	e.preventDefault();
});



function showVanish()
{
  if (!hide) {

	  hide = true;
	  $('.list').html('');

	  var ind = 0;
	  var int = setInterval(function () {

		  if (ind >= list.length) ind = 0;

		  $('.list').html('' + ( ind + 1 ) + '. <font color=green><b>' + list[ind] + '</b></font>');

		  ind++;

	  }, 2000);

  } else {

	  hide = false;
	  $('.list').html('');

  }

  return false;
}