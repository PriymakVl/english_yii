$(document).ready(function() {
	$('#subtext').change(function() {
		let text_id = get_params_url('text_id');
		let subtext_id = $(this).val();
		location.href = '/word-text/repeat?text_id=' + text_id + '&subtext_id=' + subtext_id;
	});
});