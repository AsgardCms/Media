<style>
    .jsThumbnailImageWrapper figure {
        position: relative;
        display: inline-block;
        margin-right: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #eee;
        padding: 3px;
        border-radius: 3px;
    }
    .jsThumbnailImageWrapper i.removeIcon {
        position: absolute;
        top:-10px;
        right:-10px;
        color: #f56954;
        font-size: 2em;
        background: white;
        border-radius: 20px;
        height: 25px;
    }
</style>
<script>
    if (typeof window.openMediaWindowSingle === 'undefined') {
        window.mediaZone = '';
        window.openMediaWindowSingle = function (event, zone) {
            window.mediaZone = zone;
            window.single = true;
            window.zoneWrapper = $(event.currentTarget).siblings('.jsThumbnailImageWrapper');
            window.open('{!! route('media.grid.select') !!}', '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');
        };
    }
    if (typeof window.includeMediaSingle === 'undefined') {
        window.includeMediaSingle = function (mediaId) {
            $.ajax({
                type: 'POST',
                url: '{{ route('api.media.link') }}',
                data: {
                    'mediaId': mediaId,
                    '_token': '{{ csrf_token() }}',
                    'entityClass': '{{ $entityClass }}',
                    'entityId': '{{ $entityId }}',
                    'zone': window.mediaZone
                },
                success: function (data) {
                	if (data.result.mediaType === 'image') {
                    	var mediaPlaceholder = '<img src="' + data.result.path + '" alt=""/>';
                	}
                	else {
                        var mediaPlaceholder = '<video src="' + data.result.path + '" controls width="320"></video>';
                    }
                    var html = '<figure data-id="'+ data.result.imageableId +'">' + mediaPlaceholder +
                    	'<a class="jsRemoveSimpleLink" href="#" data-id="' + data.result.imageableId + '">' +
                    	'<i class="fa fa-times-circle removeIcon"></i>' +
                    	'</a></figure>';
                    window.zoneWrapper.append(html).fadeIn('slow', function() {
                        toggleButton($(this));
                    });
                }
            });
        };
    }
</script>
<div class="form-group">
    {!! Form::label($zone, ucwords(str_replace('_', ' ', $zone)) . ':') !!}
    <div class="clearfix"></div>

    <a class="btn btn-primary btn-browse" onclick="openMediaWindowSingle(event, '{{ $zone }}');" <?php echo (isset(${$zone}->path))?'style="display:none;"':'' ?>><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>

    <div class="clearfix"></div>

    <div class="jsThumbnailImageWrapper jsSingleThumbnailWrapper">
        <?php if (isset(${$zone}->path)): ?>
            <figure data-id="{{ ${$zone}->pivot->id }}">
            <?php if (${$zone}->isImage()): ?>
                <img src="{{ Imagy::getThumbnail(${$zone}->path, (isset($thumbnailSize) ? $thumbnailSize : 'mediumThumb')) }}" alt="{{ ${$zone}->alt_attribute }}"/>
            <?php else: ?>
                <i class="fa fa-file" style="font-size: 50px;"></i>
            <?php endif; ?>
                <a class="jsRemoveSimpleLink" href="#" data-id="{{ ${$zone}->pivot->id }}">
                    <i class="fa fa-times-circle removeIcon"></i>
                </a>
            </figure>
        <?php endif; ?>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('.jsThumbnailImageWrapper').off('click', '.jsRemoveSimpleLink');
        $('.jsThumbnailImageWrapper').on('click', '.jsRemoveSimpleLink', function (e) {
            e.preventDefault();
            var imageableId = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '{{ route('api.media.unlink') }}',
                data: {
                    'imageableId': imageableId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.error === false) {
                        $(e.delegateTarget).fadeOut('slow', function() {
                            toggleButton($(this));
                        }).html('');
                    } else {
                        $(e.delegateTarget).append(data.message);
                    }
                }
            });
        });
    });

    function toggleButton(el) {
        var browseButton = el.parent().find('.btn-browse');
        browseButton.toggle();
    }
</script>
