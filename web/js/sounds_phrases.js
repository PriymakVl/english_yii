$(document).ready(function() {

    var learned_ids = '';
    var learned_qty = 0;
    var id_text;

    $('#start').click(function(event) {
        event.preventDefault();
        id_text = get_params_url('id_text');
        $(this).hide();
        $('#stop').show();
        let phrases = this.dataset.phrases.split(';');
        if (!phrases) return alert('Нет фраз');
        play_all(15000, phrases);
    });

    $('#stop').click(function(event) {
        event.preventDefault();
        location.reload();
    });

});


function play_all(delay, phrases)
{
    index = 0;
    setInterval(play_phrase, delay, phrases);
}

function play_phrase(phrases) 
{
    document.querySelectorAll('.view').forEach(item => {item.style.display = 'none'});
    let arr = phrases[index].split(':');
    sound = new Audio('/web/sounds/' + arr[0]);
    sound.play();
    setTimeout(show_text_box, 5000, 'engl', arr[1]);
    setTimeout(show_text_box, 10000, 'ru', arr[2]);
    index++;
    if (index == phrases.length) return alert('Фрафзы  пройдены');
}

function show_text_box(id, value) {
    let box = document.getElementById(id);
    box.style.display = 'block';
    box.innerText = value;
}

