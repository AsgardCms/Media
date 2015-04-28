<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('media::media.file picker') }}</title>
    {!! Theme::style('css/vendor/bootstrap.min.css') !!}
    {!! Theme::style('vendor/admin-lte/dist/css/AdminLTE.css') !!}
    {!! Theme::style('css/vendor/datatables/dataTables.bootstrap.css') !!}
    <link href="{!! Module::asset('media:css/dropzone.css') !!}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.6/css/jquery.dataTables.css"/>
    <style>
        body {
            background: #ecf0f5;
            margin-top: 20px;
        }
        .dropzone {
            border: 1px dashed #CCC;
            min-height: 227px;
            margin-bottom: 20px;
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <form method="POST" class="dropzone">
            {!! Form::token() !!}
        </form>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('media::media.choose file') }}</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool jsShowUploadForm" data-toggle="tooltip" title="" data-original-title="Upload new">
                        <i class="fa fa-cloud-upload"></i>
                        Upload new
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table class="data-table table table-bordered table-hover jsFileList data-table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>{{ trans('core::core.table.thumbnail') }}</th>
                        <th>{{ trans('media::media.table.filename') }}</th>
                        <th>{{ trans('core::core.table.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($files): ?>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td>{{ $file->id }}</td>
                            <td>
                                <img src="{{ Imagy::getThumbnail($file->path, 'smallThumb') }}" alt=""/>
                            </td>
                            <td>{{ $file->filename }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        {{ trans('media::media.insert') }} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php foreach ($thumbnails as $thumb => $filter): ?>
                                        <li data-file="{{ Imagy::getThumbnail($file->path, $thumb) }}"
                                            data-id="{{ $file->id }}" class="jsInsertImage">
                                            <a href="">{{ $thumb }}</a>
                                        </li>
                                        <?php endforeach; ?>
                                        <li class="divider"></li>
                                        <li data-file="{{ $file->path }}" class="jsInsertImage">
                                            <a href="">Original</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{!! Theme::script('js/vendor/jquery.min.js') !!}
{!! Theme::script('vendor/bootstrap/dist/js/bootstrap.min.js') !!}
{!! Theme::script('js/vendor/datatables/jquery.dataTables.js') !!}
<script src="{!! Module::asset('media:js/dropzone.js') !!}"></script>
<?php $config = config('asgard.media.config'); ?>
<script>
    var maxFilesize = '<?php echo $config["max-file-size"] ?>',
        acceptedFiles = '<?php echo $config["allowed-types"] ?>';
</script>
<script src="{!! Module::asset('media:js/init-dropzone.js') !!}"></script>
<script>
    $( document ).ready(function() {
        $('.jsShowUploadForm').on('click',function (event) {
            event.preventDefault();
            $('.dropzone').fadeToggle();
        });
    });
</script>

<?php $locale = App::getLocale(); ?>
<script type="text/javascript">
    $(function () {
        $('.data-table').dataTable({
            "paginate": true,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "language": {
                "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
            },
            "columns": [
                null,
                null,
                null,
                { "sortable": false }
            ]
        });
    });
</script>
