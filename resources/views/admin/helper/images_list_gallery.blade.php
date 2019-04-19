@forelse($article->media()->where('collection_name', 'images')->orderBy('sort')->get() as $media)
	<li id="box_media_{!! $media->id!!}" class="thumbnail">
		<div id="item_media_{!! $media->id!!}_text" class="caption">
			@if ($media->media_category_id)
				<span class="media-category">
					{!! ($media->media_category)? $media->media_category->title: '' !!}
				</span>
				<br>
			@endif
			<span class="media-title">
				@if( $media->title !=  $media->file_name)
					{!! $media->title!!}
				@endif
			</span>
		</div>
		<img src="{!! ImgHelper::get_cached($media->file_name, config('maguttiCms.image.admin')) !!}" alt="{!! $media->title!!}" border="0">
		<div class="actions">
			<a href="{{ ma_get_admin_editmodal_url($media) }}" data-target="#modal-media">
				{{icon('pencil')}}
			</a>
			<a href=" {!! ma_get_image_from_repository($media->file_name) !!}" target="_blank">
				{{icon('eye')}}
			</a>
			<a href="#" onclick="Cms.deleteItem(this);return false" id="delete_media_{!!$media->id!!}">
				{{icon('trash')}}
			</a>
		</div>
	</li>
@empty
	<li class="sort-disabled">
		{!! trans('admin.message.no_item_found')!!}
	</li>
@endforelse

@section('footerjs')
	@parent
	<script type="text/javascript">
		$(document).on('click', 'a[data-target="#modal-media"]', function(e) {
			e.preventDefault();
			var target = $(this).attr('href');

			// load the url and show modal on success
			$('#modal-media .modal-content').load(target, function() {
				console.log(target);
				$('#modal-media').modal('show');
			});
		});
	</script>
@endsection
