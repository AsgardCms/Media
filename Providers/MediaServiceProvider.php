<?php namespace Modules\Media\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Media\Console\RefreshThumbnailCommand;
use Modules\Media\Entities\File;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\Intervention\InterventionFactory;
use Modules\Media\Image\ThumbnailsManager;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Validators\MaxFolderSizeValidator;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booted(function () {
            $this->registerBindings();
        });
        $this->registerCommands();
        $this->registerMaxFolderSizeValidator();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Media\Repositories\FileRepository',
            function ($app) {
                return new EloquentFileRepository(new File(), $app['filesystem.disk']);
            }
        );
    }

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerRefreshCommand();
    }

    /**
     * Register the refresh thumbnails command
     */
    private function registerRefreshCommand()
    {
        $this->app->bindShared('command.media.refresh', function ($app) {
            $thumbnailManager = new ThumbnailsManager($app['config'], $app['modules']);
            $imagy = new Imagy(new InterventionFactory(), $thumbnailManager, $app['config']);

            return new RefreshThumbnailCommand($imagy, $app['Modules\Media\Repositories\FileRepository']);
        });

        $this->commands(
            'command.media.refresh'
        );
    }

    private function registerMaxFolderSizeValidator()
    {
        if (app()->environment() === 'testing') {
            return;
        }
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new MaxFolderSizeValidator($translator, $data, $rules, $messages);
        });
    }
}
