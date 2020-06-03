function sound_play(elem)
{
	let filename = elem.getAttribute('sound');
	if (!filename) return alert('нет файла');
	let sound = new Audio('/web/sounds/' + filename);
	sound.play();
}

function get_params_url(param_name = false)
{
    var search = window.location.search.substr(1),
    params = {};
    if (search == '') return false;   
    search.split('&').forEach(function(item) {
        item = item.split('=');
        params[item[0]] = item[1];
    });
    if (param_name) return params[param_name];
    return params;
}