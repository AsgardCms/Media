<div class="form-group">
    <style>
        figure.jsThumbnailImageWrapper {
            position: relative;
            display: inline-block;
            background-color: #fff;
            border: 1px solid #eee;
            padding: 3px;
            border-radius: 3px;
            margin-top: 20px;
        }
        figure.jsThumbnailImageWrapper i {
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
        if (typeof window.openMediaWindow === 'undefined') {
            window.mediaZone = '';
            window.openMediaWindow = function (event, zone) {
                window.mediaZone = zone;
                window.zoneWrapper = $(event.currentTarget).siblings('.jsThumbnailImageWrapper');
                window.open('{!! route('media.grid.select') !!}', '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');
            };
        }
        if (typeof window.includeMedia === 'undefined') {
            window.includeMedia = function (mediaId) {
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
                        var html = '<img src="' + data.result.path + '" alt=""/>' +
                                '<a class="jsRemoveLink" href="#" data-id="' + data.result.imageableId + '">' +
                                '<i class="fa fa-times-circle"></i>' +
                                '</a>';
                        window.zoneWrapper.append(html).fadeIn();
                    }
                });
            };
        }
    </script>
    {!! Form::label($zone, ucfirst($zone) . ':') !!}
    <div class="clearfix"></div>

    <a class="btn btn-primary" onclick="openMediaWindow(event, '{{ $zone }}');"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>

    <div class="clearfix"></div>

    <figure class="jsThumbnailImageWrapper">
        <?php if (isset(${$zone}->path)): ?>
            <img src="{{ Imagy::getThumbnail(${$zone}->path, 'mediumThumb') }}" alt=""/>
            <a class="jsRemoveLink" href="#" data-id="{{ ${$zone}->pivot->id }}">
                <i class="fa fa-times-circle"></i>
            </a>
        <?php endif; ?>
    </figure>
</div>
<script>
    $( document ).ready(function() {
        $('.jsThumbnailImageWrapper').off('click', '.jsRemoveLink');
        $('.jsThumbnailImageWrapper').on('click', '.jsRemoveLink', function (e) {
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
                        $(e.delegateTarget).fadeOut().html('');
                    } else {
                        $(e.delegateTarget).append(data.message);
                    }
                }
            });
        });
    });
</script>
