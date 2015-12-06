<?php namespace Modules\Media\Image;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Entities\File;

class Imagy
{
    /**
     * @var \Intervention\Image\Image
     */
    private $image;
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $finder;
    /**
     * @var ImageFactoryInterface
     */
    private $imageFactory;
    /**
     * @var ThumbnailsManager
     */
    private $manager;

    /**
     * All the different images types where thumbnails should be created
     * @var array
     */
    private $imageExtensions = ['jpg', 'png', 'jpeg', 'gif'];
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var Factory
     */
    private $filesystem;

    /**
     * @param ImageFactoryInterface $imageFactory
     * @param ThumbnailsManager     $manager
     * @param Repository            $config
     */
    public function __construct(ImageFactoryInterface $imageFactory, ThumbnailsManager $manager, Repository $config)
    {
        $this->image = app('Intervention\Image\ImageManager');
        $this->finder = app('Illuminate\Filesystem\Filesystem');
        $this->filesystem = app(Factory::class);
        $this->imageFactory = $imageFactory;
        $this->manager = $manager;
        $this->config = $config;
    }

    /**
     * Get an image in the given thumbnail options
     * @param  string $path
     * @param  string $thumbnail
     * @param  bool   $forceCreate
     * @return string
     */
    public function get($path, $thumbnail, $forceCreate = false)
    {
        if (!$this->isImage($path)) {
            return;
        }

        $filename = $this->config->get('asgard.media.config.files-path') . $this->newFilename($path, $thumbnail);

        if ($this->returnCreatedFile($filename, $forceCreate)) {
            return $filename;
        }

        $this->makeNew($path, $filename, $thumbnail);

        return $filename;
    }

    /**
     * Return the thumbnail path
     * @param  string $originalImage
     * @param  string $thumbnail
     * @return string
     */
    public function getThumbnail($originalImage, $thumbnail)
    {
        if (!$this->isImage($originalImage)) {
            return $originalImage;
        }

        return $this->config->get('asgard.media.config.files-path') . $this->newFilename($originalImage, $thumbnail);
    }

    /**
     * Create all thumbnails for the given image path
     * @param string $path
     */
    public function createAll($path)
    {
        if (!$this->isImage($path)) {
            return;
        }

        foreach ($this->manager->all() as $thumbnail) {
            $image = $this->image->make($path->getUrl());
            $filename = $this->config->get('asgard.media.config.files-path') . $this->newFilename($path, $thumbnail->name());
            foreach ($thumbnail->filters() as $manipulation => $options) {
                $image = $this->imageFactory->make($manipulation)->handle($image, $options);
            }
            $image = $image->stream(pathinfo($path, PATHINFO_EXTENSION));
            $this->writeImage($filename, $image);
        }
    }

    /**
     * Prepend the thumbnail name to filename
     * @param $path
     * @param $thumbnail
     * @return mixed|string
     */
    private function newFilename($path, $thumbnail)
    {
        $filename = pathinfo($path, PATHINFO_FILENAME);

        return $filename . '_' . $thumbnail . '.' . pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Return the already created file if it exists and force create is false
     * @param  string $filename
     * @param  bool   $forceCreate
     * @return bool
     */
    private function returnCreatedFile($filename, $forceCreate)
    {
        return $this->finder->isFile(public_path() . $filename) && !$forceCreate;
    }

    /**
     * Write the given image
     * @param string $filename
     * @param string $image
     */
    private function writeImage($filename, $image)
    {
        $this->filesystem->disk($this->getConfiguredFilesystem())->writeStream($filename, $image, [
            'visibility' => 'public',
            'mimetype' => 'image/png',
        ]);
//        $this->finder->put(public_path($filename), $image);
//        @chmod(public_path($filename), 0666);
    }

    /**
     * Make a new image
     * @param string      $path
     * @param string      $filename
     * @param string null $thumbnail
     */
    private function makeNew($path, $filename, $thumbnail)
    {
        $image = $this->image->make(public_path() . $path);

        foreach ($this->manager->find($thumbnail) as $manipulation => $options) {
            $image = $this->imageFactory->make($manipulation)->handle($image, $options);
        }

        $image = $image->encode(pathinfo($path, PATHINFO_EXTENSION));

        $this->writeImage($filename, $image);
    }

    /**
     * Check if the given path is en image
     * @param  string $path
     * @return bool
     */
    public function isImage($path)
    {
        return in_array(pathinfo($path, PATHINFO_EXTENSION), $this->imageExtensions);
    }

    /**
     * Delete all files on disk for the given file in storage
     * This means the original and the thumbnails
     * @param $file
     * @return bool
     */
    public function deleteAllFor(File $file)
    {
        if (!$this->isImage($file->path)) {
            return $this->finder->delete($file->path);
        }

        $paths[] = public_path() . $file->path;
        $fileName = pathinfo($file->path, PATHINFO_FILENAME);
        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
        foreach ($this->manager->all() as $thumbnail) {
            $paths[] = public_path() . $this->config->get(
                    'asgard.media.config.files-path'
                ) . "{$fileName}_{$thumbnail->name()}.{$extension}";
        }

        return $this->finder->delete($paths);
    }

    private function getConfiguredFilesystem()
    {
        return config('asgard.media.config.filesystem');
    }
}
