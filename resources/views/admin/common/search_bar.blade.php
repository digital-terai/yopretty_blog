@if(isset($pageConfig['field_searchable']))
	{!! Form::open(['id' => 'search_form', 'name'=>'search_form', 'method' => 'GET']) !!}
		<div id="search-bar" class="card">
			@foreach ($pageConfig['field_searchable'] as $key => $search_item )
				<div class="{{array_key_exists('class', $search_item)}}">
					@if ($search_item['type'] == 'relation')
						{!! AdminForm::buildSearchableField($key, $search_item, trans('admin.label.'.$search_item['label'])) !!}
					@elseif ($search_item['type'] == 'suggest')
						{!! AdminForm::buildSuggestableField($key, $search_item, trans('admin.label.'.$search_item['label'])) !!}
					@elseif ($search_item['type'] == 'integer')
						{!! Form::number($search_item['field'],'', ['class' => 'form-control', 'placeholder' => trans('admin.label.'.$search_item['label'])]) !!}
					@else
						{!! Form::text($search_item['field'],'', ['class' => 'form-control', 'placeholder' => trans('admin.label.'.$search_item['label'])]) !!}
					@endif
				</div>
			@endforeach
			<div>
				<button type="submit" class="btn btn-default" >
					{{icon('search')}}{{ trans('admin.label.search') }}
				</button>
			</div>
		</div>
	{!! Form::close() !!}
@endif
