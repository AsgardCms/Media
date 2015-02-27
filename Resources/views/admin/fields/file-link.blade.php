<div class="form-group">
    <style>
        figure.jsThumbnailImageWrapper {
            position: relative;
            display: inline-block;
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
        function includeMedia(mediaId) {
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
                    // Insert a thumbnail of the selected image
                }
            });
        }
    </script>
    {!! Form::label("thumbnail", 'Thumbnail:') !!}
    <div class="clearfix"></div>
    <?php if (isset(${$zone}->path)): ?>
    <figure class="jsThumbnailImageWrapper">
        <img src="{{ Imagy::getThumbnail(${$zone}->path, 'smallThumb') }}" alt=""/>
        <a class="jsRemoveLink" href="#" data-id="{{ ${$zone}->pivot->id }}">
            <i class="fa fa-times-circle"></i>
        </a>
    </figure>
    <?php endif; ?>
    <div class="clearfix"></div>
    <?php $url = route('media.grid.select') ?>
    <a class="btn btn-primary" onclick="window.open('{!! $url !!}', '_blank', 'menubar=no,status=no,toolbar=no,scrollbars=yes,height=500,width=1000');"><i class="fa fa-upload"></i>
        {{ trans('media::media.Browse') }}
    </a>
</div>
<script>
    $( document ).ready(function() {
        $('.jsRemoveLink').on('click', function(e) {
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
                    console.log(data);
                    if (data.error === false) {
                        $('.jsThumbnailImageWrapper').fadeOut();
                    } else {
                        $('.jsThumbnailImageWrapper').append(data.message)
                    }
                }
            });
        });
    });
</script>
