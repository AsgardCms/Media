<?php namespace Modules\Media\Tests;

use Orchestra\Testbench\TestCase;

abstract class MediaTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Pingpong\Modules\ModulesServiceProvider',
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
}
