<script type="text/javascript">
	var JS_LOCALIZATION = {};

	@foreach (config('maguttiCms.website.option.js_localization') as $_file)
		JS_LOCALIZATION['{!!$_file!!}'] = {!!json_encode(Lang::get($_file))!!};
	@endforeach
</script>
