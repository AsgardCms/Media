<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('media::media.file picker') }}</title>
    {!! Theme::style('css/vendor/bootstrap.min.css') !!}
    {!! Theme::script('js/vendor/jquery.min.js') !!}
    <style>
        h1 {
            border-bottom: 1px solid #eee;
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
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>{{ trans('media::media.choose file') }}</h1>
        </div>
    </div>
    <div class="row">
        <?php if ($files): ?>
        <?php foreach ($files as $file): ?>
        <div class="col-md-3 figureWrapper">
            <figure>
                <img src="{{ Imagy::getThumbnail($file->path, 'mediumThumb') }}" alt=""/>
                <a class="jsInsertImage btn btn-primary btn-flat" href="#" data-id="{{ $file->id }}"
                   style="display: block">{{ trans('media::media.insert') }}</a>
            </figure>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
