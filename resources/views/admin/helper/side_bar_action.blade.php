<div class="boxContainer">
	<h3>{!! trans('admin.label.action')!!}</h3>
	<ul class="nav nav-list">

		@if ($pageConfig['copy']==1 && $article->id!='')
			<li>
				<a href="{{ ma_get_admin_copy_url($article)}}"> <i class="fa fa-copy fa-fw fa-2x"></i> {!! trans('admin.label.copy')!!}</a>
			</li>
		@endif
		@if ($pageConfig['create']==1)
			<li>
				<a href="{{ ma_get_admin_create_url($article)}}"> <i class="fa fa-plus fa-fw fa-2x"></i> {!! trans('admin.message.add_new_item')!!}</a>
			</li>
		@endif
		<li>
			<a href="{{ ma_get_admin_list_url($article)  }}"> <i class="fa fa-list fa-fw fa-2x"></i> {!! trans('admin.message.back_to_list')!!}</a>
		</li>
		@if ($pageConfig['preview']==1)
			<li>
				<a href="{{  ma_get_admin_preview_url($article)  }}" target="_new"> <i class="fa fa-eye fa-fw fa-2x"></i> {!! trans('admin.message.view_page')!!}</a>
			</li>
		@endif
	</ul>
</div>
