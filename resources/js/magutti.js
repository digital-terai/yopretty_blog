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
        $('#form-newsletter').submit(function(e){
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

	function handleScrollTo() {
		$('.scroll-to').click(function(e) {
			e.preventDefault();
			var margin_top = $("nav").outerHeight();
			var elem_top = $($(this).attr('href')).offset().top;
			$('html, body').stop().animate({'scrollTop': elem_top - margin_top}, 500);
		});
	}

    return {
        init: function () {
            handleBootstrap();
            handleNewsletter();
			handleLightBox();
			handleWow();
			handleScrollTo();
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
