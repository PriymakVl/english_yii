$(document).ready(function() {
	$('#sort-state-word').change(function() {
		let state =$(this).val();
		let text_id = $(this).attr('text_id');
		location.href = '/word-text/index?text_id=' + text_id + '&state=' + state;
	});
});