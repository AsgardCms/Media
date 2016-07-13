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
        window.includeMediaMultiple = function (mediaId, filePath) {
            var html = '<figure data-id="' + mediaId + '">' +
                    '<img src="' + filePath + '" alt=""/>' +
                    '<a class="jsRemoveLink" href="#" data-id="' + mediaId + '">' +
                        '<i class="fa fa-times-circle removeIcon"></i>' +
                    '</a>' +
                    '<input type="hidden" name="medias_multi[' + window.mediaZone + '][files][]" value="' + mediaId + '">' +
                    '</figure>';
            window.zoneWrapper.append(html).fadeIn();
            if ($fileCount.length > 0) {
                var count = parseInt($fileCount.text());
                $fileCount.text(count + 1);
            }
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
        <input type="hidden" name="medias_multi[{{ $zone }}][orders]" value="" class="orders">
        <?php $zoneVar = "{$zone}Files" ?>
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
            var pictureWrapper = $(this).parent();

            pictureWrapper.fadeOut().remove();
            if ($fileCount.length > 0) {
                var count = parseInt($fileCount.text());
                $fileCount.text(count - 1);
            }
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
                $(this).find($('.orders')).val(dataSortable);
            }
        });
    });
</script>
