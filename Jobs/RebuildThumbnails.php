<?php namespace Modules\Media\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RebuildThumbnails extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Collection
     */
    private $paths;

    public function __construct(Collection $paths)
    {
        $this->paths = $paths;
    }

    public function handle()
    {
        $imagy = app('imagy');

        foreach ($this->paths as $path) {
            app('log')->info('Generating thumbnails for path: ' . $path);
            $imagy->createAll($path);
        }
    }
}
