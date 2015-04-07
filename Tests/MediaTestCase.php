<?php namespace Modules\Media\Tests;

use Orchestra\Testbench\TestCase;

abstract class MediaTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Modules\Core\Providers\CoreServiceProvider',
            'Modules\Media\Providers\MediaServiceProvider',
            'Pingpong\Modules\ModulesServiceProvider',
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
}
