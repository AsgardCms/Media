<?php namespace Modules\Media\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Media\Console\RefreshThumbnailCommand;
use Modules\Media\Entities\File;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\Intervention\InterventionFactory;
use Modules\Media\Image\ThumbnailsManager;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Repositories\FileRepository;
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
    }

    public function boot()
    {
        $this->registerMaxFolderSizeValidator();

        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'asgard.media.config');
        $this->publishes([__DIR__ . '/../Config/config.php' => config_path('asgard.media.config' . '.php'), ], 'config');

        view()->composer('media::admin.fields.file-link-multiple', function () {
            $this->assetPipeline = app('Modules\Core\Foundation\Asset\Pipeline\AssetPipeline');
            $this->assetManager = app('Modules\Core\Foundation\Asset\Manager\AssetManager');

            $this->assetManager->addAsset('jquery-ui-draggable.js', 'dashboard:vendor/jquery-ui/ui/minified/draggable.min.js');

            $this->assetPipeline->requireJs('jquery-ui-core.js');
            $this->assetPipeline->requireJs('jquery-ui-draggable.js');

        });
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
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new MaxFolderSizeValidator($translator, $data, $rules, $messages, $attributes);
        });
    }
}
