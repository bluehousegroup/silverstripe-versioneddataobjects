jQuery(document ).ready(function( $ ) {

	// we're using an invisible button to do a standard ajax post.
	$('.cms-container').on('click', '.select-version', function(e) {
		e.preventDefault();
		$('#vid').val($(this).data('vid'));
		$('#action_goSelectVersion').trigger('click');
	});

	$('.cms-container').on('click', '#action_goRollback', function(e) {
		return confirm('Rollback to this version?');
	});
});
