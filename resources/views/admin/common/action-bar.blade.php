<div id="action-bar">
	<h1>
		@if (isset($article))
			@if ($article->title!='')
				{{trans('admin.label.edit')}} {{ $article->title }}
			@elseif( $article->name!='')
				{{trans('admin.label.edit')}} {{ $article->name }}
			@endif
		@else
			{{trans('admin.models.'.$model)}}
		@endif
	</h1>
	<div class="actions">
		<button id="toolbar_deleteButtonHandler" class="btn btn-danger btn-lg"  data-role="deleteAll"
			rel="tooltip"
			data-placement="bottom"
			data-toggle="tooltip"
			title="{!! trans('admin.message.delete_items')!!}"
			data-original-title="{!! trans('admin.message.delete_items')!!}"
			style="display: none;">
			@if (config('maguttiCms.admin.option.action-bar.show-labels'))
				{{trans('admin.label.delete')}}
			@endif
			{{icon('trash')}}
		</button>
		@if ($view_name == 'admin-edit' || $view_name == 'admin-adminuser-edit')
			<a  class="btn btn-default btn-lg "
				href="{{ma_get_admin_list_url($article)}}"
				title="{!! trans('admin.message.back_to_list')!!}"
				data-toggle="tooltip"
				data-placement="bottom" rel="tooltip">
				@if (config('maguttiCms.admin.option.action-bar.show-labels'))
					{{trans('admin.label.back')}}
				@endif
				{{icon('reply')}}
			</a>
			@if ($pageConfig['preview'] && $article->id)
				<a class="btn btn-default btn-lg "
					href="{{ma_get_admin_preview_url($article)}}"
					title=" {!! trans('admin.message.view_page')!!}"
					data-toggle="tooltip"
					data-placement="bottom" rel="tooltip"
					target="_new">
					@if (config('maguttiCms.admin.option.action-bar.show-labels'))
						{{trans('admin.label.preview')}}
					@endif
					{{icon('eye')}}
				</a>
			@endif
			<a  class="btn btn-default btn-lg "
				href="#"
				onclick="document.getElementById('edit-form').submit()"
				title="{!! trans('admin.label.save')!!}"
				data-toggle="tooltip"
				data-placement="bottom"
				rel="tooltip">
				@if (config('maguttiCms.admin.option.action-bar.show-labels'))
					{{trans('admin.label.save')}}
				@endif
				{{icon('save')}}
			</a>
			@if ($pageConfig['copy'] && $article->id)
				<a class="btn btn-default btn-lg "
					href="{{ ma_get_admin_copy_url($article) }}"
					title="{!! trans('admin.label.copy')!!}"
					data-toggle="tooltip"
					data-placement="bottom" rel="tooltip">
					@if (config('maguttiCms.admin.option.action-bar.show-labels'))
						{{trans('admin.label.copy')}}
					@endif
					{{icon('copy')}}
				</a>
			@endif

		@endif
		@if ($view_name == 'admin-list' && isset($pageConfig['export_csv']) && $pageConfig['export_csv'])
			<a class="btn btn-default btn-lg"
				href="{{ ma_get_admin_export_url($pageConfig['model']) }}"
				title="{!! trans('admin.message.export_to_csv')!!}"
				target="_new"
				data-toggle="tooltip"
				data-placement="bottom" rel="tooltip">
				@if (config('maguttiCms.admin.option.action-bar.show-labels'))
					{{trans('admin.label.export')}}
				@endif
				{{icon('file-excel')}}
			</a>
		@endif
		@if ($pageConfig['create'])
			<a class="btn btn-default btn-lg"
				href="{{ ma_get_admin_create_url($pageConfig['model']) }}"
				title="{!! trans('admin.message.create')!!}"
				data-toggle="tooltip"
				data-placement="bottom" rel="tooltip">
				@if (config('maguttiCms.admin.option.action-bar.show-labels'))
					{{trans('admin.label.create_new')}}
				@endif
				{{icon('plus')}}
			</a>
		@endif
	</div>
</div>
