<?php namespace Modules\Media\Services;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Jobs\Job;
use Modules\Media\Repositories\FileRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var Queue
     */
    private $queue;
    /**
     * @var Factory
     */
    private $filesystem;

    public function __construct(
        FileRepository $file,
        Queue $queue,
        Factory $filesystem
    ) {
        $this->file = $file;
        $this->queue = $queue;
        $this->filesystem = $filesystem;
    }

    /**
     * @param  UploadedFile $file
     * @return mixed
     */
    public function store(UploadedFile $file)
    {
        $savedFile = $this->file->createFromFile($file);

        $path = $this->getDestinationPath($savedFile->getOriginal('path'));
        $stream = fopen($file->getRealPath(), 'r+');
        $this->filesystem->disk($this->getConfiguredFilesystem())->writeStream($path, $stream, [
            'visibility' => 'public',
            'mimetype' => $savedFile->mimetype,
        ]);

        $this->createThumbnails($savedFile);

        return $savedFile;
    }

    /**
     * Create the necessary thumbnails for the given file
     * @param $savedFile
     */
    private function createThumbnails($savedFile)
    {
        $this->queue->push(function (Job $job) use ($savedFile) {
            app('imagy')->createAll($savedFile->path);
            $job->delete();
        });
    }

    /**
     * @param string $path
     * @return string
     */
    private function getDestinationPath($path)
    {
        if ($this->getConfiguredFilesystem() === 'local') {
            return basename(public_path()) . $path;
        }

        return $path;
    }

    /**
     * @return string
     */
    private function getConfiguredFilesystem()
    {
        return config('asgard.media.config.filesystem');
    }
}
