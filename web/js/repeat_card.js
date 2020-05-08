$(document).ready(function() {

	$('.card__content').on('click', function() {
		let engl = $(this).attr('engl');
		let ru = $(this).attr('ru');
		let text = $(this).text();
		if (engl == text) $(this).text(ru).css('color', 'green');
		else $(this).text(engl).css('color', 'black');
	});

	$('.card__delete').click(function() {
		$(this).parent().parent().hide();
	});

	$('.card__play').click(function() {
		filename = $(this).parent().parent().attr('sound');
		sound = new Audio('/web/sounds/' + filename);
        sound.play();
	});

	$('#turn_ru').click(function() {
		cards = document.querySelectorAll('.card__content');
		cards.forEach(item => item.innerText = item.getAttribute('ru'));
		cards.forEach(item => item.style.color = 'green');
	});

	$('#turn_engl').click(function() {
		cards = document.querySelectorAll('.card__content');
		cards.forEach(item => item.innerText = item.getAttribute('engl'));
		cards.forEach(item => item.style.color = 'black');
	});
});