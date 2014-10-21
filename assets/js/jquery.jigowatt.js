jQuery(document).ready(function() {

	$('#contactform').submit(function() {

		var action = $(this).attr('action');
		var values = $(this).serialize();

		$('#submit').attr('disabled', 'disabled').after('<img src="assets/img/ajax-loader.gif" class="loader" />');

		$("#messages").slideUp(750, function() {

			$('#messages').hide();

			$.post(action, values, function(data) {
				$('#messages').html(data);
				$('#messages').slideDown('slow');
				$('#contactform img.loader').fadeOut('fast', function() {
					$(this).remove()
				});
				$('#submit').removeAttr('disabled');
				if (data.match('success') != null) $('#contactform').slideUp('slow');

			});

		});

		return false;

	});

});