<?php namespace Modules\Media\ValueObjects;

use Illuminate\Contracts\Filesystem\Factory;

class MediaPath
{
    /**
     * @var string
     */
    private $path;

    public function __construct($path)
    {
        if ( ! is_string($path)) {
            throw new \InvalidArgumentException('The path must be a string');
        }
        $this->path = $path;
    }

    /**
     * Get the URL depending on configured disk
     * @return string
     */
    public function getUrl()
    {
        $factory = app(Factory::class);

        switch ($this->getConfiguredFilesystem()) {
            case 'local':
                return $this->path;
            case 's3':
                return $factory->disk($this->getConfiguredFilesystem())->getDriver()->getAdapter()
                    ->getClient()->getObjectUrl(config('filesystems.disks.s3.bucket'), ltrim($this->path, '/'));
            default:
                return $this->path;
        }
    }

    public function __toString()
    {
        return $this->getUrl();
    }

    /**
     * @return string
     */
    private function getConfiguredFilesystem()
    {
        return config('asgard.media.config.filesystem');
    }
}
