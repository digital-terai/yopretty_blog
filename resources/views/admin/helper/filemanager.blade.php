<div id="filemanager" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">File Manager</h4>
				<ul class="nav-tabs">
					<li class="active">
						<a href="#tab-upload" data-toggle="tab" id="file-manager-upload">Upload File</a>
					</li>
					<li>
						<a href="#tab-images" data-toggle="tab" id="file-manager-list">Library</a>
					</li>
				</ul>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="tab-content">
					<div id="tab-upload" class="tab-pane active">
						<fieldset class="alert alert-info">
							<input name="upload-input" type="file" class="btn btn-primary">
							<div id="queue-modal" class="queue">{!!trans('admin.message.media_drag') !!}</div>
						</fieldset>
					</div>
					<div id="tab-images" class="tab-pane">
						<div class="row">
							<div id="tab-images-gallery" class="col-md-8 col-xs-12">
								<div class="loading text-center">
									<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
									<span class="sr-only">Loading...</span>
								</div>
							</div>
							<div id="sidebar-content" class="col-md-4 col-xs-12">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer hidden">
				<button type="button" class="btn btn-success confirm-image" data-dismiss="modal">{{icon('check')}} Select</button>
				<button type="button" class="btn btn-default reset-image">{{icon('undo')}} Reset selection</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">{{icon('times')}} Close</button>

				<input type="hidden" name="file-input" value="0">
				<input type="hidden" name="file-value" value="0">
			</div>
		</div>
	</div>
</div>
