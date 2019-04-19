<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">
		<i class="fa fa-file-text-o"></i>
		@if( $article->title!='')
			Edit {{ $article->title }}
		@elseif( $article->name!='')
			Edit {{ $article->name }}
		@else
			Create new  {{ $pageConfig['model'] }}
		@endif
	</h4>
</div>
<div class="modal-body">
	<div id="errorBox">@include('admin.common.error')</div>
	{{ Form::model($article,['id'=>'media-edit-form','class' =>'form-horizontal']) }}
	{{ AdminForm::get( $article ) }}
	@if ( config('maguttiCms.admin.list.section.'.strtolower(Str::plural($pageConfig['model'])).'s.password')  == 1)
		@include('admin.helper.password')
	@endif
	<hr>
	<div class="row">
		<div class="col-xs-6">
			<button type="reset" class="btn btn-danger btn-lg btn-block" data-dismiss="modal">
				{{icon('times')}} Close
			</button>
		</div>
		<div class="col-xs-6">
			<button type="submit" class="btn btn-success btn-lg btn-block">
				{{icon('save')}} Save
			</button>
		</div>
	</div>
	{{ Form::close() }}
</div>
<script type="text/javascript">
	$(function() {
		$('#media-edit-form').on('submit', function (ev) {
			ev.preventDefault();

			var fields = $(this).serializeArray();
			var fields_object = {};

			$.each(fields, function(i, v) {
				fields_object[v['name']] = v['value'];
			});

			if ($('#media_category_id option:selected').val())
				media_category_title = $('#media_category_id option:selected').text();
			else
				media_category_title = '';

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function (response) {
					console.log(fields_object);
					var errorsHtml = '<div class="alert alert-info"><ul>';
					errorsHtml += '<li>' + response.status + '</li>'; //showing only the first error.
					errorsHtml += '</ul></div>';
					$('#errorBox').html(errorsHtml);
					var id = '#box_media_'+fields_object.id;
					$(id+' .media-title').text(fields_object.title);
					$(id+' .media-category').text(media_category_title);
				},
				error: function (data) {
					var errors = data.responseJSON;
					var errorsHtml = '<div class="alert alert-danger"><ul>';

					$.each( errors , function( key, value ) {
						errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
					});
					errorsHtml += '</ul></div>';
					$('#errorBox').html(errorsHtml);
				}
			});
		});
	});
</script>
