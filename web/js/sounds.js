$(document).ready(function() {

    $('#start').click(function(event) {
        event.preventDefault();
        let sounds_str = this.dataset.soundsStr;
        return console.log(sounds_str);
        var delay = prompt('Укажите задержку между словами в секундах не более 30 сек', 5);
        if (!+delay) return alert('Вы не указали задержку');
        else if (+delay < 1) return alert('Слишком маленькая задержка');
        else if (+delay > 30) return alert('Слишком большая задержка'); 
        $(this).hide();
        $('#stop-sounds-page').show();
        $('.term-images img').toggle();
        play_all(Number(delay) * 1000);
    });

    $('#stop-sounds').click(function() {
        location.reload();
    });
});


function get_play_list()
{
    var sounds_arr = sounds.dataset.list.split(',');
    if (!sounds_arr) return;
    var arr = [];
    for (i = 0; i < sounds_arr.length; i++) {
        arr[i] = new Audio('/web/sounds/' + sounds_arr[i]);
    }
    return arr;
}

function play_all(delay)
{
    var playlist = get_play_list();
    if (!playlist) return alert('Нет звуковых файлов');
    var i = 0;
    setInterval(function(){
        playlist[i].play();
        i++;
        if (i == playlist.length) i = 0;
    }, delay);
}
