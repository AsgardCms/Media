<?php

namespace Modules\Media\Image;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Modules\Media\Image\Intervention\InterventionFactory;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageFactoryInterface::class, InterventionFactory::class);

        $this->app['imagy'] = $this->app->share(function ($app) {
            $factory = new InterventionFactory();
            $thumbnailManager = new ThumbnailManagerRepository($app['config'], $app['modules']);

            return new Imagy($factory, $thumbnailManager, $app['config']);
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Imagy', Facade\Imagy::class);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['imagy'];
    }
}
