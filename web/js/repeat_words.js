$(document).ready(function() {

	$('.card__content').mouseenter(function() {
		let ru = $(this).attr('ru');
		$(this).text(ru).css('color', 'green');
	});

	$('.card__content').mouseleave(function() {
		let engl = $(this).attr('engl');
		$(this).text(engl).css('color', 'black');
	});

	$('.card__content').click(function() {
		let filename = $(this).attr('sound');
		sound = new Audio('/web/sounds/' + filename);
        sound.play();
	});

	$('.card__delete').click(function() {
		$(this).parent().hide();
	});
});