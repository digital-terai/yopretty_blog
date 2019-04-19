@extends('admin.master')
@section('title', 'Admin Control Panel'.$pageConfig['title'])
@section('content')

	@include('admin.common.action-bar')

	<main id="main-list" class="container-fluid">
		@include('admin.common.search_bar')
		<h2>
			{{icon($pageConfig['icon'])}}
			{{sprintf(trans('admin.label.list_title'), trans('admin.models.'.$model))}}
		</h2>
		@include('shared.notification')
		@if ($articles->isEmpty())
			<div class="alert alert-info">{{trans('admin.message.no_item_found')}}</div>
		@else
			<div class="table-container">
				<form>
					{{ csrf_field() }}
					<div class="table-responsive">
						<table class="admin-table">
							<thead>
								<tr>
									{{ AdminList::initList($pageConfig)->getListHeader() }}
									@if ($pageConfig['edit'] || $pageConfig['copy']||$pageConfig['view']||$pageConfig['delete'])
										<th>{!! trans('admin.label.actions')!!}</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach($articles as $article)
									<tr id="row_{!! $article->id !!}">
										@if ($pageConfig['selectable'])
											<td class="selectable-column">
												<div class="form-checkbox">
													<input type="checkbox" value="{!! $article->id !!}" id="list_{!! $article->id !!}" name="list[{!! $article->id !!}]" class="checkbox" autocomplete="off">
												</div>
											</td>
										@endif
										@foreach($labels=$pageConfig['field'] as $label)
											<td class="{{isset($label['class'])? $label['class']: ''}}">
												@if (is_array($label))
													@if ( $label['type'] == 'date' )
														{!! $article->{$label['field']}->format('d/m/Y') !!}
													@elseif ( $label['type'] == 'upload' )
														<a href=" {!! ma_get_upload_from_repository($article->{$label['field']}) !!}" target="_new" download>
															{!! trans('admin.label.download')!!}
														</a>
													@elseif ( $label['type'] == 'image' && $article->{$label['field']} != '' )
														@php
															$field = $fieldspec[$label['field']];
															$disk = isset($field['disk'])? $field['disk']: '';
															$folder = isset($field['folder'])? $field['folder']: '';
															$file = $article->{$label['field']};
															// $image = ma_get_file_from_storage($file, $disk, $folder);
															$image = ma_get_image_from_repository($file, $disk, $folder);
															$thumb = ImgHelper::get_cached($file, config('maguttiCms.image.admin'), $disk, $folder);
														@endphp
														<a href="{{$image}}" class="red" target="_new">
															<img src="{{$thumb}}"  class="img-thumb">
														</a>
													@elseif ($label['type'] == 'boolean')
														@if (data_get($label,'editable'))
															@if (data_get($label, 'relation'))
																@php
																$relationObj = AdminDecorator::getBooleanRelation($article, $label);
																@endphp
																@if ($relationObj)
																	<div class="bool-toggle" data-list-boolean ="{!! $label['model'].'_'.$relationObj->id !!}" data-list-name ="{!! $label['field']!!}">
																		<span class="bool-on {{($relationObj->{$label['field']})? '' : 'hidden'}}">
																			@if (config('maguttiCms.admin.option.list.show-bool-icons'))
																				{{icon('check')}}
																			@endif
																			@if (config('maguttiCms.admin.option.list.show-bool-labels'))
																				{{trans('admin.label.active_on')}}
																			@endif
																		</span>
																		<span class="bool-off {{($relationObj->{$label['field']})? 'hidden' : ''}}">
																			@if (config('maguttiCms.admin.option.list.show-bool-icons'))
																				{{icon('times')}}
																			@endif
																			@if (config('maguttiCms.admin.option.list.show-bool-labels'))
																				{{trans('admin.label.active_off')}}
																			@endif
																		</span>
																	</div>
																@endif
															@else
																<div class="bool-toggle" data-list-boolean ="{!! $pageConfig['model'].'_'.$article->id !!}" data-list-name ="{!! $label['field']!!}">
																	<span class="bool-on {{($article->{$label['field']})? '' : 'hidden'}}">
																		@if (config('maguttiCms.admin.option.list.show-bool-icons'))
																			{{icon('check')}}
																		@endif
																			@if (config('maguttiCms.admin.option.list.show-bool-labels'))
																			{{trans('admin.label.active_on')}}
																		@endif
																	</span>
																	<span class="bool-off {{($article->{$label['field']})? 'hidden' : ''}}">
																		@if (config('maguttiCms.admin.option.list.show-bool-icons'))
																			{{icon('times')}}
																		@endif
																		@if (config('maguttiCms.admin.option.list.show-bool-labels'))
																			{{trans('admin.label.active_off')}}
																		@endif
																	</span>
																</div>
															@endif
														@else
															<div class="bool-toggle">
																@if($article->{$label['field']} == 1)
																	<i class="text-success"></i>
																@else
																	<i class="text-danger"></i>
																@endif
															</div>
														@endif
													@elseif ($label['type'] == 'editable')
														<input
															id="{!! $pageConfig['model'].'_'.$label['field'].'_'.$article->id !!}"
															class="form-control"
															name="{!! $label['field'] !!}[]"
															type="text" value="{{ $article->{$label['field']}  }}"
															data-list-value ="{!! $pageConfig['model'].'_'.$article->id !!}"
															data-list-name ="{!! $label['field']!!}"
														/>
													@elseif ($label['type'] == 'relation')
														@if( isset($label['editable']) && $label['editable'])
															<?php
															$relationObj     = AdminDecorator::getRelation($label);
															$selectObjValue  = AdminDecorator::getSelectRelationItemValue($label,$article->{$label['field']});
															$emptyLabel		 = (isset($label['label_empty']) && $label['label_empty'])? $label['label_empty']: '';
															?>
															<select id="{!! $pageConfig['model'].'_'.$label['field'].'_'.$article->id !!}"
																name="{!! $label['field'] !!}"
																data-list-value ="{!! $pageConfig['model'].'_'.$article->id !!}"
																data-list-name ="{!! $label['field']!!}"
																class="btn-select form-control"
																>
																@if ($emptyLabel)
																	<option value="">{{ $emptyLabel }}</option>
																@endif
																@foreach( $relationObj as $item )
																	<option
																	<?php echo AdminDecorator::selectedHandler($item->{$label['foreign_key']}, $article->{$label['field']}); ?>
																	value="{{ $item->{$label['foreign_key']} }}"
																	>
																		{{ $item->{$label['label_key']} }}
																	</option>
																@endforeach
															</select>
														@elseif ($article->{$label['relation']})
															@if (isset($label['multiple']) && isset($label['multiple'])==true)
																{!!implode(',',$article->{$label['relation']}->pluck($label['field'])->sortBy($label['field'])->toArray()) !!}
															@else
																{!! $article->{$label['relation']}->{$label['field']} !!}
															@endif
														@endif
													@elseif ($label['type'] == 'relation_image')
														@if($article->{$label['relation']} != null)
															<a href="{!! ma_get_image_from_repository($article->{$label['relation']}->{$label['field']} ) !!}" class="red" target="_new">
																<img src="{!! ImgHelper::get_cached($article->{$label['relation']}->{$label['field']}, config('maguttiCms.image.admin')) !!}" class="img-thumb">
															</a>
														@endif
													@elseif ($label['type'] == 'color')
														<div style="width:40px; height: 40px; border-radius: 5px !important; background-color: {{ $article->{$label['field']} }}"></div>
													@else
														{!! $article->{$label['field']} !!}
													@endif
												@else
													{!! $article->$label !!}
												@endif
											</td>
										@endforeach
										@if ($pageConfig['edit'] || $pageConfig['copy'] || $pageConfig['view'] || $pageConfig['delete'])
											<td class="list-actions">
												@if ($pageConfig['edit'])
													<a href="{{  ma_get_admin_edit_url($article) }}" class="btn btn-info"   data-role="edit-item">
														{{icon('edit')}}
														@if (config('maguttiCms.admin.option.list.show-labels'))
															{!! trans('admin.label.edit')!!}
														@endif
													</a>
												@endif
												@if ($pageConfig['copy'])
													<a href="{{  ma_get_admin_copy_url($article) }}" class="btn btn-warning"   data-role="edit-item">
														{{icon('copy')}}
														@if (config('maguttiCms.admin.option.list.show-labels'))
															{!! trans('admin.label.copy')!!}
														@endif
													</a>
												@endif
												@if ($pageConfig['view'])
													<a href="{{  ma_get_admin_view_url($article) }}" class="btn btn-primary"   data-role="edit-item">
														{{icon('eye')}}
														@if (config('maguttiCms.admin.option.list.show-labels'))
															{!! trans('admin.label.view')!!}
														@endif
													</a>
												@endif
												@if ($pageConfig['delete'])
													<a href="{{  ma_get_admin_delete_url($article) }}" class="btn btn-danger" data-role="delete-item">
														{{icon('trash')}}
														@if (config('maguttiCms.admin.option.list.show-labels'))
															{!! trans('admin.label.delete')!!}
														@endif
													</a>
												@endif
											</td>
										@endif
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</form>
			</div>
		@endif
		@if ($articles->render())
			<div class="pagination">{!! $articles->render() !!}</div>
		@endif
	</main>
@endsection

@section('footerjs')
	<script src="{!! asset(config('maguttiCms.admin.path.plugins').'selectize/selectize.min.js')!!}" type="text/javascript"></script>
	<script type="text/javascript">
	$(function() {
		$('.selectize').selectize({
			sortField: 'text'
		});
		$('.suggest-remote').selectize({
			valueField: 'id',
			labelField: 'value',
			searchField: 'value',
			sortField: 'text',
			load: function(query, callback) {
				var obj = $(this)[0];
				var cur_item = $('#'+obj.$input["0"].id)
				if (!query.length) return callback();
				$.ajax({
					url: '{!! route('api.suggest') !!}',
					type: 'GET',
					dataType: 'json',
					data: {
						q: query,
						model: cur_item.data('model'),
						value: cur_item.data('value'),
						caption: cur_item.data('caption'),
						searchFields: cur_item.data('fields'),
						accessor: cur_item.data('accessor'),
						where: cur_item.data('where')
					},
					error: function() {
						callback();
					},
					success: function(res) {
						callback(res);
					}
				});
			}
		});
	});
	</script>
@endsection
