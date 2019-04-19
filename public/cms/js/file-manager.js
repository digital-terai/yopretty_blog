$( function()
{
    var $fileManagerModal    = $( '#file-manager-modal' ).modal( { show : false } )
      , $queue               = $( '#upload-drop-queue' )
      , isQueueVisible       = false
      , isOver               = false
      , interval             = null
      , isModalVisible       = false
      , $mediaLibraryList    = $( '#tab-images' )
      , $sidebar             = $( '#modal-sidebar' )
      , $medialibraryLink    = $( '#media-library-link' )
      , $fileUpload          = $( '#file_upload' )
      , $itemsList           = $( '.items-list' )
      , isMultipleSelect     = false
      , $useSelectedImages   = $( '#use-selected-images' )
      , $resetSelectedImages = $( '#reset-selected-images' )
      , $footer              = $( '#modal-footer' )
      , $destinationList     = null
      , selectedFieldName    = ''
      , activeElements       = ''
      , $triggeredElement    = null;

    $( '.sortable-uploades-list' ).sortable().disableSelection();

    var imageDetails = function( e )
    {
        e && e.preventDefault();

        var id = $( this ).data( 'id' );

        $.ajax( {
            url      : _XHRURL + 'get-media-form&id=' + id,
            complete : function( response )
            {
                $sidebar.html( response.responseText );
                $sidebar.find( 'form' ).submit( function()
                {
                    $.ajax( {
                        url  : $( this ).attr( 'action' ),
                        type : 'post',
                        data : $( this ).serialize()
                    } );

                    return false;
                } );

                $sidebar.find( '.delete' ).children().on( 'click', function( e )
                {
                    e && e.preventDefault();

                    if( confirm( 'Are you sure that you want to remove this image ?' ) )
                    {
                        $sidebar.html( '' );
                        $itemsList.find( 'a[data-id="' + id + '"]' ).parent().remove();
                        $( 'li[item-id="' + id + '"]' ).remove();
                        $.ajax( {
                            url  : _XHRURL + 'remove-media&id=' + id,
                            type : 'post'
                        } );
                    }
                } );
            }
        } );
    };

    var activateImage = function( e )
    {
        e && e.preventDefault();

        var $list = $( this ).parent().toggleClass( 'selected' )
          , id    = $( this ).data( 'id' );

        if( $list.hasClass( 'selected' ) && !isMultipleSelect )
        {
            $list.siblings().removeClass( 'selected' );
        }

        var selecteds = $list.parent().find( '.selected' ).size();
        $footer[ selecteds ? 'show' : 'hide' ]();
    };

    var removeUploadedItem = function( e )
    {
        e && e.preventDefault();
        
        var id     = $( this ).parent().find( 'input' ).val()
          , $item  = $( this ).closest( 'ul' ).prev().children( 'a' )
          , values = $item.attr( 'data-value' ).split( ',' )

        values = jQuery.grep( values, function( value )
        {
            return value != id;
        } );

        $item.attr( 'data-value', values.join( ',' ) );

        $( this ).parent().remove();
    };

    $( '.remove-uploaded-item' ).on( 'click', removeUploadedItem );

    $resetSelectedImages.on( 'click', function( e )
    {
        e && e.preventDefault();

        $itemsList.children().removeClass( 'selected' );
        $sidebar.html( '' );
        $( this ).parent().hide();
    } );

    var createIcon = function( $item )
    {
        var thumb   = $item.data( 'thumbnail' )
          , id      = $item.data( 'id' )
          , type    = $item.data( 'type' )
          , name    = $item.data( 'name' )
          , extra   = isMultipleSelect ? '[]' : ''
          , content = type == 'image' ? '<img src="' + thumb + '" alt="">' : '<div class="label"><span>' + name + '</span></div>'
          , $icon   = $( '<li class="' + type + '"><a href="#" class="remove-uploaded-item"></a>' + content + '<input type="hidden" name="item[' + selectedFieldName + ']' + extra + '" value="' + id + '"></li>' );

        $icon.id = id;

        return $icon;
    };

    $useSelectedImages.on( 'click', function( e )
    {
        e && e.preventDefault();

        if( !isMultipleSelect )
        {
            var $icon = createIcon( $itemsList.find( '.selected' ).eq( 0 ).children() );

            $destinationList.html( '' );
            $icon.appendTo( $destinationList );
            $icon.find( '.remove-uploaded-item' ).on( 'click', removeUploadedItem );

            $triggeredElement.attr( 'data-value', $icon.id );
        }
        else
        {
            var values    = activeElements.split( ',' )
              , oldValues = activeElements.split( ',' )
              , newValues = [];

            $itemsList.find( '.selected' ).each( function()
            {
                var $icon = createIcon( $( this ).children() )
                  , id    = $icon.id; 

                if( $.inArray( id, values ) < 0 )
                {
                    values.push( id );
                    $icon.prependTo( $destinationList );
                    $icon.find( '.remove-uploaded-item' ).on( 'click', removeUploadedItem );
                }

                newValues.push( id );
            } );

            var removed = _( oldValues ).difference( newValues );

            $.each( removed, function( i, id )
            {
                $destinationList.find( 'li[item-id="' + id + '"]' ).remove();
                values = _.without( values, id );
            } );

            $triggeredElement.attr( 'data-value', values.join( ',' ) );
        }

        $fileManagerModal.modal( 'hide' );
    } );

    $itemsList.find( '.preview' ).on( 'click', activateImage );
    $itemsList.find( '.btn' ).on( 'click', imageDetails );

    $( '.image-select' ).on( 'click', function( e )
    {
        e && e.preventDefault();

        $fileManagerModal.modal( 'show' );
        $destinationList  = $( this ).parent().next();
        selectedFieldName = $( this ).data( 'name' );
        isMultipleSelect  = $( this ).data( 'multiple' );
        activeElements    = $( this ).attr( 'data-value' );
        $triggeredElement = $( this );

        $itemsList.load( _XHRURL + 'get-medias', function()
        {
            var that = this;

            $( this ).find( '.preview' ).on( 'click', activateImage );
            $( this ).find( '.btn' ).on( 'click', imageDetails );

            if( !isMultipleSelect )
            {
                var $active = $( this ).find( '.preview[data-id="' + activeElements + '"]' ).parent().addClass( 'selected' );
                
                if( $active.size() )
                {
                    $footer.show();
                }
            }
            else
            {
                var values = activeElements.split( ',' );
                
                if( values.length )
                {
                    $.each( values, function( i, value )
                    {
                        var $active = $( that ).find( '.preview[data-id="' + value + '"]' ).parent().addClass( 'selected' );
                    } );

                    if( $( that ).find( '.selected' ).size() )
                    {
                        $footer.show();
                    }
                }
            }
        } );
    } );

    $fileManagerModal.on( 'shown', function()
    {
        isModalVisible   = true;

    } ).on( 'hidden', function()
    {
        isModalVisible    = false;
        $destinationList  = null;
        selectedFieldName = '';
        $itemsList.html( '' );
    } );

    $( '#select-files' ).on( 'click', function( e )
    {
        e && e.preventDefault();

        $fileUpload.next().trigger( 'click' );
    } );

    var onFilesDrop = function( files, fileDropCount )
    {
        $medialibraryLink.trigger( 'click' );
    };

    var onUploadProgress = function( file, e )
    {
        if( e.lengthComputable )
        {
            var percent = Math.round( ( e.loaded / e.total ) * 100 );

            file.$item.find( '.bar' ).css( 'width', percent + '%' );
        }
    }; 

    var onUploadComplete = function( file, data )
    {
        data = $.parseJSON( data );

        file.$item.addClass( 'loading' );
        file.$item.children( '.preview' ).attr( 'data-id', data.id );
        file.$item.children( '.preview' ).attr( 'data-thumbnail', data.thumbnail_big );
        file.$item.children( '.preview' ).attr( 'data-type', data.file_type );
        file.$item.children( '.preview' ).attr( 'data-name', data.file_name );
        file.$item.children( '.preview' ).addClass( data.file_type );
        file.$item.children( '.btn' ).attr( 'data-id', data.id );

        var content = data.file_type == 'image' ? '<img src="' + data.thumbnail + '" alt="">' : '<div class="label"><span>' + data.file_name + '</span></div>';

        file.$item.children( '.preview' ).html( content + '<span class="tick"></span>' );
        file.$item.children( '.preview' ).on( 'click', activateImage );
        file.$item.children( '.btn' ).on( 'click', imageDetails );

        file.$item.children( '.preview' ).trigger( 'click' );
    };

    var uploadOptions = {
        auto             : true,
        queueID          : 'upload-drop-queue',
        uploadScript     : _XHRURL + 'create-media&responseType=json',
        onDrop           : onFilesDrop,
        onSelect         : onFilesDrop,
        onAddQueueItem : function()
        {
            file.fileID = new Date().getTime();
            file.$item  = $( '<li><a data-id="" data-file-id="' + file.fileID + '" class="preview uploading" href="#"><div class="pro"><div class="bar"></div></div></a><a class="btn btn-small" data-id="" href="#">edit details</a></li>' ).prependTo( $itemsList );

            file.$item.data( 'file', file );
        },
        formData         : { sec : _CURRENTSEC },
        onProgress       : onUploadProgress,
        onUploadComplete : onUploadComplete,
        onInit           : function()
        {
            $fileUpload.parent().removeClass().addClass( 'btn' ).css( 'cursor', 'pointer' );
        }
    };

    $fileUpload.uploadifive( $.extend( {
        onFallback       : function()
        {
            $( '#upload-helper' ).find( 'h3' ).html( '' );
            $fileUpload.uploadify( {
                auto     : true,
                swf      : _ADMINURL + '/theme/swf/uploadify.swf',
                queueID  : 'upload-drop-queue',
                uploader : _XHRURL + 'create-media&responseType=json',
                formData : { sec : _CURRENTSEC },
                onInit   : function()
                {
                    $( '#file_upload-button' ).addClass( 'btn' );
                },
                onSelect : function( file )
                {
                    $medialibraryLink.trigger( 'click' );

                    file.$item  = $( '<li><a data-id="" data-file-id="' + file.creationdate.getTime() + '" class="preview uploading" href="#"><div class="pro"><div class="bar"></div></div></a><a class="btn btn-small" data-id="" href="#">edit details</a></li>' ).prependTo( $itemsList );
                    file.$item.data( 'file', file );
                },
                onUploadSuccess  : function( file, data )
                {
                    data = $.parseJSON( data );

                    file.$item = $( 'a[data-file-id="' + file.creationdate.getTime() + '"]' ).parent();

                    file.$item.addClass( 'loading' );
                    file.$item.children( '.preview' ).attr( 'data-id', data.id );
                    file.$item.children( '.preview' ).attr( 'data-thumbnail', data.thumbnail_big );
                    file.$item.children( '.btn' ).attr( 'data-id', data.id );

                    file.$item.children( '.preview' ).html( '<img src="' + data.thumbnail + '" alt=""><span class="tick"></span>' );
                    file.$item.children( '.preview' ).on( 'click', activateImage );
                    file.$item.children( '.btn' ).on( 'click', imageDetails );
                },
                onUploadProgress : onUploadProgress
            } );
        }
    }, uploadOptions ) );

    $( document ).on( 'dragover', function( e )
    {
        e.stopPropagation();
        e.preventDefault();

        if( !isQueueVisible && isModalVisible )
        {
            isQueueVisible = true;
            $queue.stop().fadeIn( 60 );
        }
    } );

    $queue.on( 'dragover', function( e )
    {
        e.preventDefault();

        clearInterval( interval );

        interval = setInterval( function()
        {
            isOver = false;
            clearInterval( interval );

            if( isQueueVisible )
            {
                isQueueVisible = false;
                $queue.stop().fadeOut( 20 );
            }
        }, 100 );

        if( !isOver )
        {
            isOver = true;
        }
    } );

} );