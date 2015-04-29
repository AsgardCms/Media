<?php namespace Modules\Media\Tests;

use Orchestra\Testbench\TestCase;

abstract class MediaTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
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
            'LaravelLocalization' => 'Mcamara\LaravelLocalization\Facades\LaravelLocalization'
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
        $app['config']->set('asgard.media.thumbnails', $conf);
    }
}
