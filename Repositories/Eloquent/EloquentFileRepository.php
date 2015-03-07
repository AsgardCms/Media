<?php namespace Modules\Media\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Media\Entities\File;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Repositories\FileRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EloquentFileRepository extends EloquentBaseRepository implements FileRepository
{
    /**
     * Update a resource
     * @param  File  $file
     * @param $data
     * @return mixed
     */
    public function update($file, $data)
    {
        $file->update($data);

        return $file;
    }

    /**
     * Create a file row from the given file
     * @param  UploadedFile $file
     * @return mixed
     */
    public function createFromFile(UploadedFile $file)
    {
        $fileName = FileHelper::slug($file->getClientOriginalName());

        $exists = $this->model->whereFilename($fileName)->first();

        if ($exists) {
            throw new \InvalidArgumentException('File slug already exists');
        }

        return $this->model->create([
            'filename' => $fileName,
            'path' => "/assets/media/{$fileName}",
            'extension' => $file->guessClientExtension(),
            'mimetype' => $file->getClientMimeType(),
            'filesize' => $file->getFileInfo()->getSize(),
        ]);
    }

    public function destroy($file)
    {
        $file->delete();
    }
}
