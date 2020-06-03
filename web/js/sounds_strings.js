$(document).ready(function() {

    var learned_ids = '';
    var learned_qty = 0;
    var text_id;

    $('#start').click(function(event) {
        event.preventDefault();
        id_text = get_params_url('text_id');
        $(this).hide();
        $('#stop').show();
        let strings = this.dataset.strings.split(';');
        if (!strings) return alert('Нет строк');
        play_all(15000, strings);
    });

    $('#stop').click(function(event) {
        event.preventDefault();
        location.reload();
    });

});


function play_all(delay, strings)
{
    index = 0;
    setInterval(play_strings, delay, strings);
}

function play_strings(strings) 
{
    document.querySelectorAll('.view').forEach(item => {item.style.display = 'none'});
    let arr = strings[index].split(':');
    sound = new Audio('/web/sounds/' + arr[0]);
    sound.play();
    setTimeout(show_text_box, 5000, 'engl', arr[1]);
    setTimeout(show_text_box, 10000, 'ru', arr[2]);
    index++;
    show_statistics(strings);
    if (index == strings.length) return alert('Строки пройдены');
}

function show_text_box(id, value) {
    let box = document.getElementById(id);
    box.style.display = 'block';
    box.innerText = value;
}

function show_statistics(strings) {
    str_all.innerText = strings.length;
    str_sounded.innerText = index;
    str_rest.innerText = strings.length - index;
}

