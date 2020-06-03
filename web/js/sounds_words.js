$(document).ready(function() {

    var learned_ids = '';
    var learned_qty = 0;
    var text_id;

    $('#start').click(function(event) {
        event.preventDefault();
        text_id = get_params_url('text_id');
        $(this).hide();
        $('#stop').show();
        let words = this.dataset.soundsStr.split(';');
        if (!words) return alert('Нет слов');
        // $('.well').text(word_arr[2]).show();
        // var delay = prompt('Укажите задержку между словами в секундах не более 30 сек', 5);
        // if (!+delay) return alert('Вы не указали задержку');
        // else if (+delay < 1) return alert('Слишком маленькая задержка');
        // else if (+delay > 30) return alert('Слишком большая задержка'); 
        play_all(9000, words);
    });

    $('#stop').click(function(event) {
        event.preventDefault();
        let id_text = $(this).attr('id_text');
        if (learned_ids) {
            let add_learned = confirm('Добавить выбранные слова в выученные');
            if (add_learned) return location.href = '/text-word/state-list?ids=' + learned_ids + '&id_text=' + id_text;
        }
        location.reload();
    });

    $('#learned').click(function() {
        learned_ids += $('#id_word').text() + ',';
        learned_qty++;
        $(this).find('span').text('(' + learned_qty + ')');
    });
});


function play_all(delay, words)
{
    var i = 0;
    setInterval(function(){
        document.querySelectorAll('.view').forEach(item => {item.style.display = 'none'});
        let arr = words[i].split(':');
        $('#id_word').text(arr[3]);//id item for change state
        sound = new Audio('/web/sounds/' + arr[0]);
        sound.play();
        setTimeout(show_text_box, 3000, 'engl', arr[1]);
        setTimeout(show_text_box, 6000, 'ru', arr[2]);
        i++;
        show_statistics(i, words)
        if (i == words.length) {
            // if (learned_ids) {
            //     let id_text = $(this).attr('id_text');
            //     let add_learned = confirm('Добавить слова в выученные');
            //     if (add_learned) return location.href = '/text-word/state-list?ids=' + learned_ids + '&id_text=' + id_text;
            // }
            return alert('Слова пройдены');
        }
    }, delay);
}

function show_text_box(id, value) {
    let box = document.getElementById(id);
    box.style.display = 'block';
    box.innerText = value;
}

function show_statistics(i, words) {
    word_all.innerText = words.length;
    word_sounded.innerText = i;
    word_rest.innerText = words.length - i;
}
