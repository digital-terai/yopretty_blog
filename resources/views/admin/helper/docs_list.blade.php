
@forelse($article->media()->where('collection_name','docs')->orderBy('sort')->get() as $media)
    <li id="box_media_{!! $media->id!!}" class="thumbnail">
		<div id="item_media_{!! $media->id!!}_text" class="caption">{!! $media->title!!}</div>
        <div class="actions">
            <a href="{{  ma_get_admin_editmodal_url($media) }}" data-toggle="modal"    data-target="#modal-media">
				{{icon('pencil')}}
			</a>
            <a href=" {!!   ma_get_doc_from_repository($media->file_name) !!}" class="red" target="_new">
				{{icon('eye')}}
			</a>
            <a href="#" class="red" onclick="Cms.deleteItem(this);return false" id="delete_media_{!! $media->id!!}">
				{{icon('trash')}}
			</a>
        </div>
    </li>
@empty
    <li class="sort-disabled">{!! trans('admin.message.no_item_found')!!}</li>
@endforelse
