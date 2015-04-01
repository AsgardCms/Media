<div class="form-group">
    <style>
        .btn-upload {
            margin-bottom: 20px;
        }
        .jsThumbnailImageWrapper figure {
            position: relative;
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 20px
            background-color: #fff;
            border: 1px solid #eee;
            padding: 3px;
            border-radius: 3px;
        }
        .jsThumbnailImageWrapper i {
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
        function includeMedia(mediaId) {
            var $fileCount = $('.jsFileCount');
            $.ajax({
                type: 'POST',
                url: '{{ route('api.media.link') }}',
                data: {
                    'mediaId': mediaId,
                    '_token': '{{ csrf_token() }}',
                    'entityClass': '{{ $entityClass }}',
                    'entityId': '{{ $entityId }}',
                    'zone': '{{ $zone }}'
                },
                success: function(data) {
                    var html = '<figure><img src="' + data.result.path + '" alt=""/>' +
                            '<a class="jsRemoveLink" href="#" data-id="' + data.result.imageableId + '">' +
                            '<i class="fa fa-times-circle"></i>' +
                            '</a></figure>';
                    $('.jsThumbnailImageWrapper').append(html).fadeIn();
                    if ($fileCount.length > 0) {
                        var count = parseInt($fileCount.text());
                        $fileCount.text(count + 1);
                    }
                }
            });
        }
    </script>
    {!! Form::label($zone, ucfirst($zone) . ':') !!}
    <div class="clearfix"></div>
    <?php $url = route('media.grid.select') ?>
    <a class="btn btn-primary btn-upload" onclick="window.open('{!! $url !!}', '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>
    <div class="clearfix"></div>
    <div class="jsThumbnailImageWrapper">
        <?php $zoneVar = "{$zone}Files"  ?>
        <?php if (isset($$zoneVar)): ?>
        <?php foreach ($$zoneVar as $file): ?>
        <figure>
            <img src="{{ Imagy::getThumbnail($file->path, 'mediumThumb') }}" alt=""/>
            <a class="jsRemoveLink" href="#" data-id="{{ $file->pivot->id }}">
                <i class="fa fa-times-circle"></i>
            </a>
        </figure>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script>
    $( document ).ready(function() {
        $('.jsRemoveLink').on('click', function(e) {
            e.preventDefault();
            var imageableId = $(this).data('id'),
                    pictureWrapper = $(this).parent(),
                    $fileCount = $('.jsFileCount');

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
    });
</script>
