<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('media::media.file picker') }}</title>
    {!! Theme::style('css/vendor/bootstrap.min.css') !!}
    {!! Theme::style('vendor/admin-lte/dist/css/AdminLTE.css') !!}
    {!! Theme::style('css/vendor/datatables/dataTables.bootstrap.css') !!}
    <style>
        body {
            background: #ecf0f5;
        }

        .figureWrapper {
            margin-bottom: 20px;
        }

        .figureWrapper a.btn {
            border-radius: 0 0 3px 3px;
        }

        figure {
            background-color: #fff;
            border: 1px solid #eee;
            padding: 3px;
            border-radius: 3px;
        }
        .box {
            margin-top: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ trans('media::media.choose file') }}</h3>
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
                                <a class="jsInsertImage btn btn-primary btn-flat" href="#" data-id="{{ $file->id }}">
                                    {{ trans('media::media.insert') }}
                                </a>
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
{!! Theme::script('js/vendor/datatables/jquery.dataTables.js') !!}
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
