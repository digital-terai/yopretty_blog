<label for="{{$properties['label']}}">
	{{$properties['label']}}
	@if (isset($properties['required']) && $properties['required'])
		<mark>*</mark>
	@endif
	@if (isset($properties['extraMsg']) && $properties['extraMsg'])
		<br>
		<span class="help-inline small extraMsg">({{$properties['extraMsg']}})</span>
	@endif
</label>
