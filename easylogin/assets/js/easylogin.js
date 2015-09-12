window.EasyLogin = {};

$(function() {
	
	EasyLogin.signout = function(redirect) {
		$.post(EasyLogin.config.ajax_url, {action:'signout'}, function() {
			if (redirect)
				window.location.href = redirect;
			else 
				window.location.reload();
		});
	};

	var 
	alertMessage = function(el, message, type) {
		if (message == 0 & !type) {
			el.fadeOut();
			return;
		}
	   	
   		el.find('span').html(message);
   		el.removeClass('alert-danger alert-warning alert-success');
   		switch(type) {
   			case 1:
				el.addClass('alert-warning');
			break;
   			case 2:
   				el.addClass('alert-danger');
   			break;
   			case 3:
   				el.addClass('alert-success');
   			break;
   		}
   		el.fadeIn();
	},

	ajaxPost = function(form) {
		var 
		field = function(name) {
			if (form.find('[name="'+name+'"]').length)
				return form.find('[name="'+name+'"]');
			return false;
		},
		action = field('action').val(),
		alert = form.find('.alert'),
		ajaxDone, ajaxFail, responseSuccess, responseError;

		$.fn.tval = function() {
			return $.trim($(this).val());
   		}; 

		switch (action) {
			case 'signin':
				var user = field('username'),
					pass = field('password');

				if (!user.tval().length)
					return user.focus();
				if (!pass.tval().length)
					return pass.focus();

				responseSuccess = function(response) {
					if (response)
						window.location.href = response;
					else 
						window.location.reload();
				};
			break;

			case 'signup':
				var user = field('username'),
					email = field('email'),
					name = field('name'),
					pass = field('password'),
					captcha = field('recaptcha_response_field');

				if (user && !user.tval().length)
					return user.focus();
				if (!email.tval().length)
					return email.focus();
				if (name && !name.tval().length)
					return name.focus();
				if (!pass.tval().length)
					return pass.focus();
				if (captcha && !captcha.tval().length)
					return captcha.focus();

				responseSuccess = function(response) {
					$('#EL_signup').modal('hide');
					if (response)
						$('#EL_signup_complete1').modal('show');
					else 
						$('#EL_signup_complete2').modal('show');
				};
			break;

			case 'forgot_pass':
				var email = field('email'),
					captcha = field('recaptcha_response_field');

				if (!email.tval().length)
					return email.focus();
				if (captcha && !captcha.tval().length)
					return captcha.focus();

				responseSuccess = function() {
					$('#EL_forgot_pass').modal('hide');
					$('#EL_recover_sent').modal('show');
				};
			break;

			case 'resend_activation':
				var email = field('email'),
					captcha = field('recaptcha_response_field');

				if (!email.tval().length)
					return email.focus();
				if (captcha && !captcha.tval().length)
					return captcha.focus();

				responseSuccess = function() {
					$('#EL_resend_activation').modal('hide');
					$('#EL_signup_complete1').modal('show');
				};
			break;

			case 'recover_pass':
				var pass1 = field('password'),
					pass2 = field('confirm_password');

				if (!pass1.tval().length)
					return pass1.focus();
				if (pass1.val() != pass2.val())
					return alertMessage(alert, EasyLogin.msgs.pass_not_match, 2);

				responseSuccess = function() {
					form.find('.modal-body').html(EasyLogin.msgs.pass_changed);
					form.find('.modal-footer').remove();
					window.location.hash = '';
				};
			break;

			case 'account':
				var email = field('email'),
					name = field('name'),
					website = field('website'),
					pass1 = field('password'),
					pass2 = field('confirm_password');

				if (!email.tval().length && $('#account_general').hasClass('active'))
					return email.focus();

				if (name && !name.tval().length)
					return name.focus();

				if (pass1.tval().length) {
					if (!pass1.tval().length)
						return pass1.focus();

					if (pass1.val() != pass2.val())
						return alertMessage(alert, EasyLogin.msgs.pass_not_match, 2);

					if (pass1.tval().length < 4 || pass1.tval().length > 20)
						return alertMessage(alert, EasyLogin.msgs.invalid_password, 2);
				}

				responseSuccess = function(response) {
					if (response.pass_changed)
						alertMessage(alert, EasyLogin.msgs.pass_changed2, 3);
					else
						alertMessage(alert, EasyLogin.msgs.saved, 3);

					pass1.val('');
					pass2.val('');
					var avatarSrc = $('#EL_account img.user-avatar').attr('src');
					$('img.user-avatar').attr('src', avatarSrc);

					setTimeout(function(){ alertMessage(alert, 0) }, 5000);
				};
			break;
		}
		
		alertMessage(alert, 0);

		$.ajax({
			url: EasyLogin.config.ajax_url,
			type: 'POST',
			dataType: 'json',
			data: {action: action, data: form.serialize()},
			beforeSend: function() {
				form.find('[type="submit"]').prop('disabled', true);
				form.find('.ajax-loader').css('display', 'inline-block');
			}
		})
		.done(function(response) {
			if (ajaxDone)
				return ajaxDone(response);

			if (response.success && responseSuccess)
				return responseSuccess(response.data);

			if (responseError)
				return responseError(response.data);

			var el = $('<ul/>'), 
				errors = response.data;

			if (errors.length > 1)
				for (var i = 0; i < errors.length; i++)
					el.append( $('<li/>', { html: EasyLogin.msgs[errors[i]] || errors[i] }) );
			else 
				el = EasyLogin.msgs[errors[0]] || EasyLogin.msgs.error;

			alertMessage(alert, el, 2);

		})
		.fail(function() {
			if (ajaxFail)
				ajaxFail();
			else
				alertMessage(alert, EasyLogin.msgs.error, 2);
		})
		.always(function() {
			form.find('[type="submit"]').prop('disabled', false);
			form.find('.ajax-loader').hide();

			if (typeof Recaptcha == 'object')
				Recaptcha.reload();
		});
	};

	// Dismiss
	$('.close.dismiss').on('click', function(e) {
		$(this).parent().fadeOut(100);
		e.preventDefault();
	});

	// Submit
	$('.easylogin-form').on('submit', function(e) {
		ajaxPost( $(this) );
		e.preventDefault();
	});

	$('#EL_signin').on('show.bs.modal', function () {
		$('[id^=EL_]:not(#EL_signin)').modal('hide');
	});

	$('#EL_forgot_pass, #EL_resend_activation').on('show.bs.modal', function () {
		$('#EL_signin').modal('hide');
	});

	// Clear all inputs when modal hiddes
	$('[id^=EL_]').on('hidden.bs.modal', function(e) {
		$(e.target).find('form').find('input:not([name="action"],[name="avatartype"]), textarea, select').val('');
		$(e.target).find('.alert').hide();
	});

	// Load recaptcha for signup an forgot pass modals
	$('#EL_signup, #EL_forgot_pass, #EL_resend_activation').on('show.bs.modal', function(e) {
		var template = $('#recaptchaTemplate');
		if (template.length) {
			$('.recaptcha-group').html('');
			$(e.target).find('.recaptcha-group').html( template.html() );

			$.getScript('http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', function() {
				var public_key = $('[name="recaptcha_public_key"]').val();
				Recaptcha.create(public_key, 'easylogin_recaptcha', {
					theme : 'custom',
					custom_theme_widget: 'easylogin_recaptcha'
				});
			});
		}
	});

	// My account
	$('#EL_account').on('show.bs.modal', function(e) {
		var form = $(e.target).find('form');
		
		form.find('[data-toggle="tab"]').on('click', function() {
			form.find('.alert').hide();
			form.find('[name="password"]').val('');
			form.find('[name="confirm_password"]').val('');
		});

		form.find('[name="avatartype"]').on('click', function(e) {
			$.get(EasyLogin.config.ajax_url, {
				action: 'get_avatar',
				type: $(e.target).val()
			}, function(response) {
				if (response.success)
					$('#EL_account img.user-avatar').attr('src', response.data);
			}, 'json');
		});

		$.get(EasyLogin.config.ajax_url, {action: 'userdata'}, function(response) {
			if (response.success) {
				form.find('[name="email"]').val(response.data.email);
				form.find('[name="name"]').val(response.data.name);
				form.find('[name="url"]').val(response.data.url);
				form.find('#account_settings').html(response.data.custom_fields_html);
				form.find('[name="avatartype"][value="'+response.data.avatar+'"]').prop('checked', true);
				form.find('img.user-avatar').attr('src', response.data.avatarUrl);
			}
		}, 'json');
	});

	// Activate & Recover checks
	var hash = window.location.hash;
	if (hash.substr(1, 9) == 'activate-') {

		$.post(EasyLogin.config.ajax_url, {
			action:'activate_account', 
			activation_key: hash.substr(10, hash.length)
		}, function(response) {
			
			if (response.success) 
				$('#EL_account_activated').modal('show');
			else 
				alert(EasyLogin.msgs[response.data[0]] || EasyLogin.msgs.error);

			window.location.hash = '';
		}, 'json');

	} else if (hash.substr(1, 8) == 'recover-') {
		var recover_key = hash.substr(9, hash.length);
		$.post(EasyLogin.config.ajax_url, {
			action:'check_recover_key', 
			recover_key: recover_key
		}, function(response) {
			
			if (response.success) {
				$('#EL_recover_pass').modal('show');
				$('#EL_recover_pass input[name="recover_key"]').val(recover_key);
			} else 
				alert(EasyLogin.msgs[response.data[0]] || EasyLogin.msgs.error);

		}, 'json');
	}

	var ua = navigator.userAgent.toLowerCase(), isIE = false;
	if (ua.indexOf('msie') >= 0 || ua.indexOf('trident/') >= 0)
		isIE = true;

	$('.edit-avatar').imgPicker({
		el: '.user-avatar',
		minWidth: 100,
		minHeight: 100,
		title: '更變您的頭像 / Change your avatar',
		api: EasyLogin.config.ajax_url,
		swf_url: EasyLogin.config.script_url + 'assets/webcam.swf',
		complete: function() {
			$('.easylogin-form').trigger('submit');
			if (isIE)
				$('#EL_account').show();
		},
		cancel: function() {
			if (isIE)
				$('#EL_account').show();
		}
	}).on('click', function() {
		$('[name="avatartype"][value="uploaded"]').prop('checked', true).trigger('click');
		if (isIE)
			$('#EL_account').hide();
	});
});

EasyLogin.msgs = {
	error: 'Unexpected Error.',
	invalid_credentials: 'Invalid credentials !',
	invalid_name: 'Enter a valid name',
	invalid_username: 'Enter a valid username',
	invalid_email: 'Enter a valid email address',
	invalid_password: 'Enter a valid password, minimum 4, maximum 20 characters',
	invalid_captcha: 'Invalid captcha',
	unique_email: 'This email is already registed',
	unique_username: 'This username is already taken',
	disabled: 'Your account is disabled :(',
	unconfirmed: 'Your account is not activated.',
	no_account: 'No account found',
	invalid_activation_key: 'Invalid activation link.',
	already_activated: 'Your account is already activated.',
	invalid_recover_key: 'Invalid recover link',
	pass_not_match: 'Passwords do not mach',
	pass_changed: '<p>Password successfully changed.</p><p> You can <a href="#" data-toggle="modal" data-target="#EL_signin">sign in</a> now.</p>',
	pass_changed2: 'Password changed.',
	saved: 'Settings saved.'
};