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