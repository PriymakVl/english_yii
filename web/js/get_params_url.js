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
