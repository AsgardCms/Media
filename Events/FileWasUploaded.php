<?php namespace Modules\Media\Events;

use Modules\Media\Entities\File;

class FileWasUploaded
{
    private $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }
}
