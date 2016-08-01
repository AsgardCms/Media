<script src="{{ Module::asset('dashboard:vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $fileCount = $('.jsFileCount');
</script>
<style>
    .btn-upload {
        margin-bottom: 12px;
    }
    .jsThumbnailImageWrapper {
        padding-top: 8px;
        overflow-y: auto;
    }
    .jsThumbnailImageWrapper figure {
        position: relative;
        display: inline-block;
        margin-right: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid #eee;
        padding: 3px;
        border-radius: 3px;
        cursor: grab;
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

    figure.ui-state-highlight {
        border: none;
        width:100px;
        height: 0;
    }
</style>
<script>
    if (typeof window.openMediaWindowMultiple === 'undefined') {
        window.mediaZone = '';
        window.openMediaWindowMultiple = function (event, zone) {
            window.single = false;
            window.mediaZone = zone;
            window.zoneWrapper = $(event.currentTarget).siblings('.jsThumbnailImageWrapper');
            window.open('{!! route('media.grid.select') !!}', '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');
        };
    }
    if (typeof window.includeMediaMultiple === 'undefined') {
        window.includeMediaMultiple = function (mediaId) {
            $.ajax({
                type: 'POST',
                url: '{{ route('api.media.link') }}',
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
                    	'<a class="jsRemoveLink" href="#" data-id="' + data.result.imageableId + '">' +
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
    <?php $url = route('media.grid.select') ?>
    <a class="btn btn-primary btn-upload" onclick="openMediaWindowMultiple(event, '{{ $zone }}')"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>
    <div class="clearfix"></div>
    <div class="jsThumbnailImageWrapper">
        <?php $zoneVar = "{$zone}Files"  ?>
        <?php if (isset($$zoneVar)): ?>
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
                url: '{{ route('api.media.unlink') }}',
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
                    url: '{{ route('api.media.sort') }}',
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
