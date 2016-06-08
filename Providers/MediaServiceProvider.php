<?php namespace Modules\Media\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Media\Console\RefreshThumbnailCommand;
use Modules\Media\Entities\File;
use Modules\Media\Events\Handlers\HandleMediaStorage;
use Modules\Media\Events\Handlers\RemovePolymorphicLink;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Repositories\FileRepository;

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
        $this->registerBindings();

        $this->registerCommands();
    }

    public function boot(DispatcherContract $events)
    {
        $this->registerMaxFolderSizeValidator();

        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'asgard.media.config');
        $this->publishes([__DIR__ . '/../Config/config.php' => config_path('asgard.media.config' . '.php'), ], 'config');

        $events->listen('*', HandleMediaStorage::class);
        $events->listen('*', RemovePolymorphicLink::class);
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
        $this->app->bind(FileRepository::class, function ($app) {
            return new EloquentFileRepository(new File(), $app['filesystem.disk']);
        });
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
            return new RefreshThumbnailCommand($app['Modules\Media\Repositories\FileRepository']);
        });

        $this->commands('command.media.refresh');
    }

    private function registerMaxFolderSizeValidator()
    {
        Validator::extend('max_size', '\Modules\Media\Validators\MaxFolderSizeValidator@validateMaxSize');
    }
}
