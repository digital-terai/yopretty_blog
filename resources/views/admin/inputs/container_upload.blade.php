<div class="row form-group">
	<div class="col-xs-12 col-sm-3 col-lg-2">
		@include('admin.inputs.label')
	</div>
	{{Form::hidden($key, $value , array('class' => ' form-control '.$css_class))}}
	<div class="col-xs-12 col-sm-9 col-md-10 {{$css_class}}">
		<div class="media-cont">
			<div class="media-input">
				<fieldset class="alert alert-info">
					<input id="file_upload_{{$key}}" type="file" class="btn btn-primary file_upload_single" data-key="{{$key}}">
					<div>
						<div id="queue_{{$key}}" class="queue">{{trans('admin.message.media_drag')}}</div>
					</div>
				</fieldset>
				<a href="javascript:$('#file_upload_{{$key}}').uploadifive('upload')" class="btn btn-primary hidden">
					{{icon('download')}}{{trans('admin.label.upload_file')}}
				</a>
			</div>
			@if ($model->$key)
				<div id="box_{{$key}}_{{$model->id}}" class="media-saved">
					<div>
						@if ($properties['mediaType'] == 'Img')
							<img class="img-thumb" src="{{ImgHelper::get_cached($model->$key, ['w' => 100, 'h' => 100, 'q' => 50], isset($properties['disk'])? $properties['disk']: '', isset($properties['folder'])? $properties['folder']: '')}}">
						@else
							<a href="/admin/file_view/{{strtolower(Str::plural(class_basename($model))).'/'.$model->id.'/'.$key}}" target="_blank" class="btn btn-primary btn-block">
								{{icon('eye')}}{{trans('admin.label.view')}}
							</a>
						@endif
					</div>
					@include('admin.inputs.delete_button', ['key' => $key, 'id' => $model->id])
				</div>
			@endif
		</div>
	</div>
</div>
