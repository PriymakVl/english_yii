$(document).ready(function() {

	$('.card__content span').on('click', function() {
		let text = $(this).attr('title');
		let title = $(this).text();
		$(this).text(text).attr('title', title).toggleClass('green');
	});

	$('.card__hide').click(function() {
		$(this).parent().parent().hide();
	});

	$('.card__play').click(function() {
		filename = $(this).attr('sound');
		sound = new Audio('/web/sounds/' + filename);
        sound.play();
	});

	$('.card__learned').click(function() {
		let word_id = $(this).attr('word_id');
		$.get( "/word/set-state", { id: word_id } ).done((data) => $(this).parent().parent().hide());
	});

	$('#turn_lang').click(function() {
		let text = $(this).text();
		text = (text == 'English') ? 'Russion' : 'English';
		$(this).text(text);
		let cards = document.querySelectorAll('.card__content span');
		cards.forEach(changeLanguage);
	});
});

function changeLanguage(item) {
	let title = item.innerText;
	let text = item.getAttribute('title');
	$(item).text(text).attr('title', title).toggleClass('green');
}