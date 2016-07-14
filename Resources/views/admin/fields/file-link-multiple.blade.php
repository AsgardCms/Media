<script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    var $fileCount = $('.jsFileCount');
    if (typeof window.openMediaWindowMultipleOld === 'undefined') {
        window.mediaZone = '';
        window.openMediaWindowMultipleOld = function (event, zone) {
            window.single = false;
            window.old = true;
            window.mediaZone = zone;
            window.zoneWrapper = $(event.currentTarget).siblings('.jsThumbnailImageWrapper');
            window.open(Asgard.mediaGridSelectUrl, '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');
        };
    }
    if (typeof window.includeMediaMultipleOld === 'undefined') {
        window.includeMediaMultipleOld = function (mediaId) {
            $.ajax({
                type: 'POST',
                url: Asgard.mediaLinkUrl,
                data: {
                    'mediaId': mediaId,
                    '_token': '{{ csrf_token() }}',
                    'entityClass': '{{ $entityClass }}',
                    'entityId': '{{ $entityId }}',
                    'zone': window.mediaZone,
                    'order': $('.jsThumbnailImageWrapper figure').size() + 1
                },
                success: function (data) {
                    if (data.result.mediaType === 'image') {
                        var mediaPlaceholder = '<img src="' + data.result.path + '" alt=""/>';
                    }
                    else {
                        var mediaPlaceholder = '<video src="' + data.result.path + '" controls + width="320"></video>';
                    }
                    var html = '<figure data-id="'+ data.result.imageableId +'">' + mediaPlaceholder +
                    	'<a class="jsRemoveSimpleLink" href="#" data-id="' + data.result.imageableId + '">' +
                    	'<i class="fa fa-times-circle removeIcon"></i>' +
                    	'</a></figure>';
                    window.zoneWrapper.append(html).fadeIn();
                    if ($fileCount.length > 0) {
                        var count = parseInt($fileCount.text());
                        $fileCount.text(count + 1);
                    }
                }
            });
        };
    }
</script>
<div class="form-group">
    {!! Form::label($zone, ucwords(str_replace('_', ' ', $zone)) . ':') !!}
    <div class="clearfix"></div>
    <a class="btn btn-primary btn-upload" onclick="openMediaWindowMultipleOld(event, '{{ $zone }}')"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>
    <div class="clearfix"></div>
    <div class="jsThumbnailImageWrapper">
        <?php $zoneVar = "{$zone}Files"  ?>
        <?php if (isset($$zoneVar) && !$$zoneVar->isEmpty()): ?>
            <?php foreach ($$zoneVar as $file): ?>
                <figure data-id="{{ $file->pivot->id }}">
                    <img src="{{ Imagy::getThumbnail($file->path, (isset($thumbnailSize) ? $thumbnailSize : 'mediumThumb')) }}" alt="{{ $file->alt_attribute }}"/>
                    <a class="jsRemoveLink" href="#" data-id="{{ $file->pivot->id }}">
                        <i class="fa fa-times-circle removeIcon"></i>
                    </a>
                </figure>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('.jsThumbnailImageWrapper').on('click', '.jsRemoveLink', function (e) {
            e.preventDefault();
            var imageableId = $(this).data('id'),
                    pictureWrapper = $(this).parent();
            $.ajax({
                type: 'POST',
                url: Asgard.mediaUnlinkUrl,
                data: {
                    'imageableId': imageableId,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.error === false) {
                        pictureWrapper.fadeOut().remove();
                        if ($fileCount.length > 0) {
                            var count = parseInt($fileCount.text());
                            $fileCount.text(count - 1);
                        }
                    } else {
                        pictureWrapper.append(data.message);
                    }
                }
            });
        });

        $(".jsThumbnailImageWrapper").not(".jsSingleThumbnailWrapper").sortable({
            placeholder: 'ui-state-highlight',
            cursor:'move',
            helper: 'clone',
            containment: 'parent',
            forcePlaceholderSize: false,
            forceHelperSize: true,
            update:function(event, ui) {
                var dataSortable = $(this).sortable('toArray', {attribute: 'data-id'});
                $.ajax({
                    global: false, /* leave it to false */
                    type: 'POST',
                    url: Asgard.mediaSortUrl,
                    data: {
                        'entityClass': '{{ $entityClass }}',
                        'zone': '{{ $zone }}',
                        'sortable': dataSortable,
                        '_token': '{{ csrf_token() }}'
                    }
                });
            }
        });
    });
</script>
