<?php namespace Modules\Media\Tests;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Translation\TranslationServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Maatwebsite\Sidebar\SidebarServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\Media\Providers\MediaServiceProvider;
use Orchestra\Testbench\TestCase;
use Pingpong\Modules\ModulesServiceProvider;
use Pingpong\Modules\Providers\BootstrapServiceProvider;

abstract class MediaTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TranslationServiceProvider::class,
            ModulesServiceProvider::class,
            BootstrapServiceProvider::class,
            CoreServiceProvider::class,
            MediaServiceProvider::class,
            ImageServiceProvider::class,
            LaravelLocalizationServiceProvider::class,
            HtmlServiceProvider::class,
            SidebarServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelLocalization' => LaravelLocalization::class,
            'Validator' => Validator::class,
            'Form' => FormFacade::class,
            'Html' => HtmlFacade::class,
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
        $app['config']->set('asgard.media.config', ['filesystem' => 'local']);
        $app['config']->set('asgard.media.thumbnails', $conf);
        $app['config']->set('modules', [
            'namespace' => 'Modules',
        ]);
        $app['config']->set('modules.paths.modules', realpath(__DIR__ . '/../Modules'));
    }
}
