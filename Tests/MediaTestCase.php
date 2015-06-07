<?php namespace Modules\Media\Tests;

use Orchestra\Testbench\TestCase;

abstract class MediaTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Illuminate\Translation\TranslationServiceProvider',
            'Pingpong\Modules\ModulesServiceProvider',
            'Pingpong\Modules\Providers\BootstrapServiceProvider',
            'Modules\Core\Providers\CoreServiceProvider',
            'Modules\Media\Providers\MediaServiceProvider',
            'Intervention\Image\ImageServiceProvider',
            'Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelLocalization' => 'Mcamara\LaravelLocalization\Facades\LaravelLocalization',
            'Validator' => 'Illuminate\Support\Facades\Validator',
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $conf = [
            'smallThumb' => [
                'fit' => [
                    'width' => 50,
                    'height' => 50,
                    'callback' => function ($constraint) {
                        $constraint->upsize();
                    },
                ],
            ],
        ];
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('asgard.media.thumbnails', $conf);
        $app['config']->set('modules', [
            'namespace' => 'Modules',
        ]);
        $app['config']->set('modules.paths.modules', realpath(__DIR__ . '/../Modules'));
    }
}
