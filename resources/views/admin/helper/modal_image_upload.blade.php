<div class="modal fade" id="file-manager-modal" tabindex="-1" data-keyboard="false">

    <div class="modal-header">
        <div class="header-inner">
            <h4> File Manager</h4>
            <ul id="modal-tabs" class="unstyled head-menu">
                <li class="active"><a href="#tab-upload" data-toggle="tab"><?php print _('Upload file'); ?></a></li>
                <li><a href="#tab-images" data-toggle="tab"
                       id="media-library-link"><?php print _('Media library'); ?></a></li>
            </ul>
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        </div>
    </div>

    <div id="modal-sidebar"><!-- --></div>
    <div class="modal-content">
        <div class="tab-content">
            <div class="tab-pane active" id="tab-upload">
                <div id="upload-helper">
                    <input id="itemId" name="itemId" type="hidden" value="{!! $article->id!!}">
                    <fieldset class="alert alert-info">
                        <input id="file_upload_modal" name="file_upload_modal" type="file" multiple="true"
                               class="btn btn-primary">
                        <h4>{!!trans('admin.message.media_drag') !!}</h4>

                        <div>
                            <div id="queue-modal">{!!trans('admin.message.media_drag') !!}</div>
                        </div>

                    </fieldset>
                    <a href="javascript:$('#file_upload').uploadifive('upload')" class="btn btn-primary hidden">
                        <i class="fa fa-download"></i> {!! trans('admin.label.upload_file')!!}
                    </a>
                </div>
            </div>
            <div class="tab-pane" id="tab-images">
                    <div id="tab-images-gallery">
                        <ul class="thumbnails list-unstyled" id="modalGallery"><ul>
                    </div>

                <div id="modal-footer" class="file-manager-modal-footer">
                    <a href="#" class="btn btn-large btn-primary"
                       id="use-selected-images"><?php print _('Use selected files'); ?></a>
                    <a href="#" class="btn btn-large"
                       id="reset-selected-images"><?php print _('Reset selected files'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>