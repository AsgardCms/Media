<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('media::media.file picker') }}</title>
    {!! Theme::style('css/vendor/bootstrap.min.css') !!}
    {!! Theme::script('js/vendor/jquery.min.js') !!}
    <style>
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ trans('media::media.choose file') }}</h1>

            <?php if ($files): ?>
            <ul class="list-unstyled">
              <?php foreach ($files as $file): ?>
                  <li class="pull-left" style="margin-right: 20px">
                      <img src="{{ $file->path }}" alt="" class="img-thumbnail" style="width: 250px;"/>
                      <a class="jsInsertImage btn btn-primary btn-flat" href="#" style="display: block">{{ trans('media::media.insert') }}</a>
                  </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
  <script>
    $( document ).ready(function() {
        $('.jsInsertImage').on('click', function(e) {
            e.preventDefault();
            function getUrlParam( paramName ) {
                var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;
                var match = window.location.search.match(reParam) ;

                return ( match && match.length > 1 ) ? match[ 1 ] : null ;
            }
            var funcNum = getUrlParam( 'CKEditorFuncNum' );

            window.close();
        });
    });
  </script>
</body>
</html>
