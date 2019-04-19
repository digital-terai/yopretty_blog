<select class="form-control" name="{{$key}}">
	@if (!$properties['required'])
		<option value=""></option>
	@endif
	@foreach (config('app.locales') as $_code => $_name)
		<option value="{{$_code}}" {{($value == $_code)? 'selected': ''}}>
			{{$_name}}
		</option>
	@endforeach
</select>
