<?php

namespace Modules\Media\Composers\Backend;

use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Modules\Core\Foundation\Asset\Types\AssetTypeFactory;

class PartialAssetComposer
{
    /**
     * @var AssetManager
     */
    private $assetManager;
    /**
     * @var AssetPipeline
     */
    private $assetPipeline;
    /**
     * @var AssetTypeFactory
     */
    private $assetFactory;

    public function __construct()
    {
        $this->assetManager = app(AssetManager::class);
        $this->assetPipeline = app(AssetPipeline::class);
        $this->assetFactory = app(AssetTypeFactory::class);
    }

    public function compose()
    {
        $this->addAssets();
        $this->requireAssets();
    }

    /**
     * Add the assets from the config file on the asset manager
     */
    private function addAssets()
    {
        foreach (config('asgard.media.config.media-partial-assets', []) as $assetName => $path) {
            $path = $this->assetFactory->make($path)->url();
            $this->assetManager->addAsset($assetName, $path);
        }
    }

    /**
     * Require assets from asset manager
     */
    private function requireAssets()
    {
        $this->assetPipeline->requireCss(config('asgard.media.config.media-partial-required-assets.css'));
        $this->assetPipeline->requireJs(config('asgard.media.config.media-partial-required-assets.js'));
    }
}
