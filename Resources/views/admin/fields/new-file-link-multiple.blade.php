<div class="form-group">
    {!! Form::label($zone, ucwords(str_replace('_', ' ', $zone)) . ':') !!}
    <div class="clearfix"></div>
    <a class="btn btn-primary btn-upload" onclick="openMediaWindowMultiple(event, '{{ $zone }}')"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>
    <div class="clearfix"></div>
    <div class="jsThumbnailImageWrapper">
        <?php $zoneVar = "{$zone}Files" ?>
        <?php if (isset($$zoneVar) && !$$zoneVar->isEmpty()): ?>
        <?php $order_list = [] ?>
        <?php foreach ($$zoneVar as $file): ?>
        <?php $order_list[$zone][] = $file->id; ?>
        <figure data-id="{{ $file->id }}">
            <img src="{{ Imagy::getThumbnail($file->path, (isset($thumbnailSize) ? $thumbnailSize : 'mediumThumb')) }}" alt="{{ $file->alt_attribute }}"/>
            <a class="jsRemoveLink" href="#" data-id="{{ $file->pivot->id }}">
                <i class="fa fa-times-circle removeIcon"></i>
            </a>
            <input type="hidden" name="medias_multi[{{ $zone }}][files][]" value="{{ $file->id }}">
        </figure>
        <?php endforeach; ?>
        <input type="hidden" name="medias_multi[{{ $zone }}][orders]" value="{{ implode(',', $order_list[$zone]) }}" class="orders">
        <?php else: ?>
        <input type="hidden" name="medias_multi[{{ $zone }}][orders]" value="" class="orders">
        <?php endif; ?>
    </div>
</div>