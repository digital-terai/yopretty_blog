<div class="filemanager-list">
	@forelse($medias as $media)
		<a id="media-id-{{ $media->id }}" href="#" data-id="{{ $media->id }}">
			@if($media->collection_name == 'images')
				<img src="{!! ImgHelper::get_cached($media->file_name, array('w' => '200', 'h' => '200', 'c' => 'contain', 'q' => '60' )) !!}" alt="{{ $media->alt }}" title="{{ $media->title }}">
			@else
				<i class="fa fa-file-text-o fa-5x" aria-hidden="true"></i>
			@endif
			<span>{{ $media->title }}</span>
		</a>
	@empty
		{!! trans('admin.message.no_item_found') !!}
	@endforelse
</div>
