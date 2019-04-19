window.urlAjaxHandlerCms = _SERVER_PATH + '/admin/api/'; // percorso  del contenuto del  dialog

window.curItem;

window.Cms = function () {
	function handleBootstrap() {
		$('[data-toggle="tooltip"]').tooltip();

		/*Popovers*/
		jQuery('.popovers').popover();
		jQuery('.popovers-show').popover('show');
		jQuery('.popovers-hide').popover('hide');
		jQuery('.popovers-toggle').popover('toggle');
		jQuery('.popovers-destroy').popover('destroy');

		jQuery('[data-toggle="buttons-radio"]').button();
	}
	function handleToggle() {
		jQuery('.list-toggle').on('click', function () {
			jQuery(this).toggleClass('active');
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

	function handleFlashMessage() {
		jQuery('div.flash').not('.alert-important').delay(1500).slideUp();
	}

	function listHandler() {
		$(':input[data-list-value]').on('change', function () {
			var value = $(this).val();
			var itemArray = $(this).data('list-value').split('_');
			var field = $(this).data('list-name');
			if ($(this).is(':checkbox')) {
				value = ( $(this).is(":checked") ) ? 1 : 0;
			}
			$.ajax({
				url: urlAjaxHandlerCms + 'update/updateItemField/' + itemArray[0] + '/' + itemArray[1],
				data: {
					model: itemArray[0],
					field: field,
					value: value
				},
				type: "GET",
				dataType: 'json',
				cache: false,
				success: function (response) {
					//  suppress
					$.notify(response.message, "success");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$.notify("Something went Wrong please" + xhr.responseText + thrownError);
				}
			}
		);
	});

	$('[data-list-boolean]').on('click', function () {
		var itemArray = $(this).data('list-boolean').split('_');
		var field = $(this).data('list-name');
		var onObj = $(this).find(".bool-on");
		var offObj = $(this).find(".bool-off");
		var value = ( onObj.hasClass('hidden') ) ? 1 : 0;
		$.ajax({
			url: urlAjaxHandlerCms + 'update/updateItemField/' + itemArray[0] + '/' + itemArray[1],
			data: {
				model: itemArray[0],
				field: field,
				value: value
			},
			type: "GET",
			dataType: 'json',
			cache: false,
			success: function (response) {
				//  suppress
				onObj.toggleClass('hidden');
				offObj.toggleClass('hidden');
				$.notify(response.message, "success");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$.notify("Something went Wrong please" + xhr.responseText + thrownError);
			}
		});
	});


	$('[data-role="delete-item"]').on('click', function (e) {
		e.preventDefault();
		var curItem = this;
		bootbox.setLocale(_LOCALE);
		bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
			if (confirmed) {
				location.href = curItem.href;
			}
		});
	});

	// gestione check box liste
	$('input.checkbox').click(function () {
		if ($("input.checkbox:checked").length > 0)
			$('#toolbar_deleteButtonHandler').stop().fadeIn();
		else
			$('#toolbar_deleteButtonHandler').stop().fadeOut();
	});

	$('#toolbar_editButtonHandler').on('click', function (e) {
		e.preventDefault();
		//  redirect to edit page
		location.href = $('#row_' + curItem + ' [data-role="edit-item"] ')[0].href;
	});

	$('#toolbar_deleteButtonHandler').on('click', function (e) {
		e.preventDefault();
		//  redirect to edit page
		var role = $(this).data('role');
		bootbox.setLocale(_LOCALE);
		bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
			if (confirmed) {
				$('input.checkbox:checked').each(function (index) {
					$('#row_' + $(this).val()).fadeOut('1000');
					deleteUrl = $('#row_' + $(this).val() + ' [data-role="delete-item"] ')[0].href;
					// Do delete
					curModel = _CURMODEL;
					$.ajax({
						url: urlAjaxHandlerCms + 'delete/' + curModel + '/' + $(this).val(),
						type: "GET",
						dataType: 'json',
						cache: false,
						success: function (response) {
							//  suppress
							//$.notify(response.message, "success");
						},
						error: function (xhr, ajaxOptions, thrownError) {
							$.notify("Something went Wrong please" + xhr.responseText + thrownError);
						}
					});
				});
				$.notify("Selected items have been deleted");
			}
		});
	});
}

return {
	init: function () {
		handleBootstrap();
		//handleIEFixes();
		listHandler();
		handleFlashMessage();
		handleToggle();
		initCheckboxes();
	},

	initDatePicker: function() {
		$( ".datepicker" ).datepicker({
			dateFormat: "dd-mm-yy"
		});
	},

	initUploadifiveSingle: function () {
		$('.file_upload_single').each(function() {
			var elem = $(this);
			elem.uploadifive({
				'auto'             : true,
				//'checkScript'      : 'check-exists.php',
				'queueID'          : 'queue_' + elem.data('key'),
				'uploadScript'     : urlAjaxHandlerCms+'uploadifiveSingle',
				'onAddQueueItem' : function(file) {
					this.data('uploadifive').settings.formData = {
						'timestamp' : '1451682058',
						'token'     : '4b9fe8f26d865150e4b26b2a839d4f2b',
						'Id'        :  $('#itemId').val(),
						'myImgType' :  $('#myImgType').val(),
						'model'     :  _CURMODEL,
						'key'		: elem.data('key'),
						"_token" :  $('[name=_token]').val()
					};
				},
				'onUploadComplete' : function(file, data) {
					var responseObj = jQuery.parseJSON(data);
					var mediaType   =  responseObj.data;
					var filename = responseObj.filename;
					$('[name="' + elem.data('key') + '"]').val(filename);
				}
			});
		});
	},
	initUploadifiveMedia:function () {
		var elem = $('#file_upload_media');
		elem.uploadifive({
			'auto'             : true,
			//'checkScript'      : 'check-exists.php',
			'queueID'          : 'queue_media',
			'uploadScript'     : urlAjaxHandlerCms+'uploadifiveMedia',
			'onAddQueueItem' : function(file) {
				this.data('uploadifive').settings.formData = {
					'timestamp' : '1451682058',
					'token'     : '4b9fe8f26d865150e4b26b2a839d4f2b',
					'Id'        :  $('#itemId').val(),
					'myImgType' :  $('#myImgType').val(),
					'model'     :  _CURMODEL,
					'key'		: elem.data('key'),
					"_token" :  $('[name=_token]').val()
				};
			},
			'onUploadComplete' : function(file, data) {
				let responseObj = jQuery.parseJSON(data);
				if(responseObj.status=='ko'){
					alert(responseObj.error);
					let errorHtml = `<span style ="color:red"> ${responseObj.error}</span>`;
					$('.fileinfo').html(errorHtml);
				}
				else {
					let mediaType   =  responseObj.data;
					let mediaObjContaner = (mediaType=='images')? "#simpleGallery":"#simpleDocGallery";
					$(mediaObjContaner).load( urlAjaxHandlerCms + 'updateHtml/' + mediaType + '/' + _CURMODEL + '/'+ $('#itemId').val());
				}
			}
		});
	},

	initTinymce: function () {

		tinymce.init({
			selector: "textarea.wyswyg",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor textcolor colorpicker",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste hr pagebreak"
			],
			pagebreak_split_block: true,
			toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
	},

	initColorPicker: function () {
		$('.color-picker').colorpicker({
			'format': 'hex'
		});
	},

	initFiles: function() {
		let inputs = $('.form-file').find('input[type="file"]');
		inputs.each(function() {
			let elem = $(this),
				label = elem.siblings('label').first(),
				labeltext = label.html();
			elem.on('change', function(e) {
				Cms.updateFile(elem, label);
			});
			elem.on('focus', function() {elem.addClass('has-focus');});
			elem.on('blur', function() {elem.removeClass('has-focus');});
		});
	},
	updateFile: function(elem, label) {
		let fileName = '';
		files = elem[0].files;
		if (files && files.length > 1)
			fileName = (elem.data('selected-caption') || '').replace('{count}', files.length);
		else
			fileName = elem.val().split('\\').pop();

		if (fileName)
			label.html(fileName);
		else
			label.html(labeltext);
	},

	initSortableList: function (object) {
		$(object).sortable({
			revert: true,
			items: "li:not(.sort-disabled)",
			update: function (ev, ui) {
				var order = $(object).sortable('serialize');
				$("#info").load(urlAjaxHandlerCms + "updateMediaSortList?" + order);
			}
		});
		$("ul#simpleGallery").disableSelection();
	},
	initImageRelationList: function() {
		$('[data-image-relation]').on('click', function () {
			var targetField   = $(this).data('image-relation');
			var targetFieldValue = $(this).data('image-id');
			$("#"+targetField).val(targetFieldValue);
			$('[data-image-relation="'+targetField +'"]').each(function (index) {
				$(this).removeClass('active');
				$(this).addClass('inactive');
			});
			$(this).addClass('active');
		});
	},
	initDateTimePicker:function () {
		$('.datetimepicker').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd-mm-yy',
			timeFormat: 'HH:mm:ss',
			hourMin: 6,
			hourMax: 22
		});
	},

	deleteImages: function (obj) {
		bootbox.setLocale(_LOCALE);
		bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
			var curItem = obj;
			var value = "";
			var itemArray = curItem.id.split('-');
			var field = itemArray[1];
			var boxObj = $("#box_" + itemArray[1] + "_" + itemArray[2]);

			if (confirmed) {
				$.ajax({
					url: urlAjaxHandlerCms + 'update/updateItemField/' + _CURMODEL + '/' + itemArray[2],
					data: {
						model: _CURMODEL,
						field: field,
						value: value
					},
					type: "GET",
					dataType: 'json',
					cache: false,
					success: function (response) {
						// set input value as null
						$('input[name='+ itemArray[1] +']').val('');

						//  suppress
						$.notify(response.message, "success");
						// hide  the   media  preview  container
						boxObj.hide();
					},
					error: function (xhr, ajaxOptions, thrownError) {
						$.notify("Something went Wrong please" + xhr.responseText + thrownError);
					}
				});
			}
		});
	},

	deleteItem: function (obj) {
		bootbox.setLocale(_LOCALE);
		bootbox.confirm("<h4>Are you sure?</h4>", function (confirmed) {
			var curItem = obj;
			var value = "";
			var itemArray = curItem.id.split('_');
			var boxObj = $("#box_" + itemArray[1] + "_" + itemArray[2]);

			if (confirmed) {
				$.ajax({
					url: urlAjaxHandlerCms + 'delete/' + itemArray[1] + '/' + itemArray[2],
					type: "GET",
					dataType: 'json',
					cache: false,
					success: function (response) {
						//  suppress
						$.notify(response.message, "success");
						// hide  the   media  preview  container
						boxObj.hide();
					},
					error: function (xhr, ajaxOptions, thrownError) {
						$.notify("Something went Wrong please" + xhr.responseText + thrownError);

					}
				});
			}
		});
	}
};
}();
