<div class="row form-group">
	<div class="col-xs-12 col-sm-3 col-lg-2">
		@include('admin.inputs.label')
	</div>
	<div class="col-xs-12 col-sm-9 col-md-10">
		<div class="media-cont">
			<div class="media-input">
				{!!$form_element!!}
			</div>
			@if ($model->$key)
				<div id="box_{{$key}}_{{$model->id}}" class="media-saved">
					<div>
						@if ($properties['mediaType'] == 'Img')
							<img class="img-thumb" src="{{ImgHelper::get_cached($model->$key, config('maguttiCms.image.admin'), isset($properties['disk'])? $properties['disk']: '', isset($properties['folder'])? $properties['folder']: '')}}">
						@else
							<a href="{{ma_get_doc_from_repository($key)}}" target="_blank" class="btn btn-primary">
								{{trans('admin.label.view')}}
							</a>
						@endif
					</div>
					@include('admin.inputs.delete_button', ['key' => $key, 'id' => $model->id])
				</div>
			@endif
		</div>
	</div>
</div>
