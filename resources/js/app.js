window.App = function () {
    function handleBootstrap() {
        /*Bootstrap Carousel*/
        $('.carousel').carousel({
            interval: 5000,
            pause: 'hover'
        });

        /*Tooltips*/
        $('.tooltips').tooltip();
        $('.tooltips-show').tooltip('show');
        $('.tooltips-hide').tooltip('hide');
        $('.tooltips-toggle').tooltip('toggle');
        $('.tooltips-destroy').tooltip('destroy');

        /*Popovers*/
        $('.popovers').popover();
        $('.popovers-show').popover('show');
        $('.popovers-hide').popover('hide');
        $('.popovers-toggle').popover('toggle');
        $('.popovers-destroy').popover('destroy');
    }

    function handleNewsletter() {
        var msg = '';
        $('#btn-newsletter-subscribe').click(function(e){
			e.preventDefault();
            //showWait();
            $.ajax({
                type : 'POST',
                url : urlAjaxHandler+"/api/newsletter",
                data : $( "#form-newsletter" ).serialize(),
                dataType : 'json',
                success : function(response) {
                    var msgHtml = '';
                    if (response.status=='ok') {
                        msgHtml += '<h4>' + response.msg + '</h4>';
                    }
                    else {
                       $.each( response.errors , function( key, value ) {
                            msgHtml += '<h4>' + value[0] + '</h4>'; //showing only the first error.
                        });
                    }
                    updateModalAlertMsg(msgHtml);
                },
                error : function(response) {
                    updateModalAlertMsg('Error');
                }
            });
        });
    }

	// checkboxes and radio
    function initCheckboxes() {
        $('input[type="checkbox"], input[type="radio"]').change(function() {
            var elem = $(this);
            if (elem.is('input[type="radio"]')) {
                $('input[type="radio"][name="' + elem.attr('name') + '"]').each(function() {
                    updateCheckbox($(this));
                });
            } else
                updateCheckbox($(this));
        }).each(function() {
            updateCheckbox($(this));
        });
    }

    function updateCheckbox(elem) {
        var checked = elem.is(':checked');
        if (checked)
            elem.closest('.form-checkbox, .form-radio').addClass('checked');
        else
            elem.closest('.form-checkbox, .form-radio').removeClass('checked');
    }

	function handleLightBox() {
		$(".lightbox").fancybox({
		});
	}

	function handleWow() {
		window.wow.init({
			mobile:	false,	// default
			live:	false	// default
		});
	}

	function scrollTo(hash) {
		var margin_top = $("nav").outerHeight();
		var elem_top = $(hash).offset().top;
		$('html, body').stop().animate({'scrollTop': elem_top - margin_top}, 500);
	}

	function handleScrollTo() {
		$('.scroll-to').click(function(e) {
			e.preventDefault();
			scrollTo($(this).attr('href'));
		});
		if (window.location.hash) {
			scrollTo(window.location.hash);
		}
	}

	function handleGhostInputs() {
		$('.form-ghost').each(function() {
			let elem = $(this);
			elem.data('original', elem.val());
		}).blur(function(e) {
			e.preventDefault();

			let elem = $(this);

			if (elem.val() != elem.data('original')) {
				let id  = $(this).data('id');
				let model  = $(this).data('model');
				let field  = $(this).data('field');
				let value  = $(this).val();

				$.ajax({
					type : 'POST',
					url : '/api/update-ghost',
					data : {
						id : id,
						model: model,
						field: field,
						value: value,
						_token: Laravel.csrfToken
					},
					dataType : 'json',
					success : function(response, status) {
						elem.data('original', value);
						$.each(response.alerts, function() {
							$.smkAlert({
								text: this.text,
								type: this.type,
								time: this.time
							});
						});
					},
					error : function(response) {
						$.smkAlert({
							text: trans('website.ghost.error'),
							type: 'danger',
							time: 5
						});
					}
				});
				return true;
			}
		});
	}

    return {
        init: function () {
            handleBootstrap();
            handleNewsletter();
			handleLightBox();
			handleWow();
			handleScrollTo();
			handleGhostInputs();
			initCheckboxes();
        },
		formValidation: function(selector) {
		      var msg = '';
		      $('#'+selector).submit(function (event) {
		        event.preventDefault();

		       $.ajax({
		            type: 'POST',
		            url: urlAjaxHandler + '/api/' + selector,
		            data: $('#'+selector).serialize(),
		            dataType: 'json',
		            success: function (response) {
		              if (response.status == 'ok') {
		                $('#'+selector).hide();
		                $('#response').show().text(response.msg);
		              }else {
		                $.each(response.errors, function (key, value) {
		                  $('[name="' + key + '"]').addClass('error');
		                });

		               $('html, body').animate({
		                  scrollTop: $('#'+selector).offset().top - $('nav').height()
		                }, 1200, 'swing');
		              }
		            },
		            error: function (response) {
		                //console.log(response.errors.email);
		            }
		        });
		    });
		}
    };
}();

/******************************** MODAL ************************/
function updateModalAlertMsg($htmlContent) {
    bootbox.alert($htmlContent, function(result) {});
}

function updateModalBoxMsg($htmlContent) {
    bootbox.confirm($htmlContent, function(result) {});
}

/*********************************  localize *********************/
function trans(keystring) {
	var key_array = keystring.split('.');
	var temp_localization = JS_LOCALIZATION;
	$.each(key_array, function() {
		temp_localization = temp_localization[this];
	});
	if (typeof(temp_localization) == 'string')
		return temp_localization;
	else
		return keystring;
}
